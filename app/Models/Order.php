<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Session;
use DB;

class Order extends Model
{
    protected $table = 'crm_orders';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
      'crm_id',
      'wb_id',
      'web_id',
      'user_id',
      'kunden_id',
      'netto',
      'brutto',
      'vat',
      'payment_status',
      'payment_amount',
      'status',
      'created',
      'modified',
      'removed',
      'editable',
      'comment',
      'ignored_products',
    ];

    static function store_file($file) {
      if(self::sanitize_file($file)):
        $filename = $file->getClientOriginalName();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $moved = $file->move('public/uploads', $filename);
        return $moved ? asset('public/uploads/' . $filename) : false;
      endif;
      return false;
    }

    static function store_message_files($files, $message_id) {
      $files = @array_filter($files);
      if($files):
        foreach($files as $file):
          if(self::sanitize_file($file)):
            $original = $file->getClientOriginalName();
            $extension = pathinfo($original, PATHINFO_EXTENSION);
            $filename = 'user_upload_' . time() . '.' . $extension;
            $file->move('public/uploads', $filename);
            DB::table('crm_tickets_messages_files')->insert([
              'message_id' => $message_id,
              'file' => $filename,
              'original' => $original,
              'extension' => $extension,
            ]);
          endif;
        endforeach;
      endif;
      return true;
    }

    static function sanitize_file($file) {
      $accepted = ['doc','docx','xls','xlsx','csv','pdf','txt','jpg','jpeg','png','gif','php','js','html','xml'];
      return in_array(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION), $accepted);
    }

    static function add_new_message(array $request) {
      return DB::table('crm_tickets_messages')->insertGetId([
        'order_id' => $request['order_id'],
        'user_id' => $request['user_id'],
        'message' => $request['message'],
      ]);
    }

    static function get_message(int $id = 0) {
      $entity = DB::table('crm_tickets_messages')->where('id', $id)->select(['order_id', 'user_id', 'message', 'created'])->first();
      if($entity):
        $entity->created = strtotime($entity->created);
        $entity->files = DB::table('crm_tickets_messages_files')->where('message_id', $id)->get();
        foreach($entity->files as &$file):
          $file->path = '/public/uploads/' . $file->file;
        endforeach;
        return collect($entity)->toArray();
      endif;
      return null;
    }

    static function get_status_name(string $dbp = '', int $status_id) {
      $status = collect(DB::select("SELECT ".$dbp."name as name FROM crm_tickets_statuses WHERE id = $status_id LIMIT 1"))->first();
      return $status ? $status->name : null;
    }

    static function get_chat(string $dbp = '', $filters = null) {
      $uid = Session::get('user_id');
      $chat = (object)[];
      $chat->per_page = 8;
      $chat->page = 1;
      $limit = "LIMIT 0, " . $chat->per_page;
      $conditions = "";
      $sorting = "ORDER BY stm.id DESC";
      if($filters):
        if(isset($filters->order_id) && $filters->order_id) $conditions .= " AND stm.order_id = $filters->order_id";
        if($chat->page = $filters->page) $limit =  "LIMIT " . ( $chat->page * $chat->per_page - $chat->per_page ) . ", " . $chat->per_page;
      endif;
      $chat->list = DB::select("
        SELECT stm.*,
        (SELECT user_id FROM crm_orders WHERE crm_id = stm.order_id LIMIT 1) as owner_id
        FROM crm_tickets_messages stm
        WHERE 1
        $conditions
        $sorting
        $limit
      ");
      foreach($chat->list as &$message):
        $message->files = DB::select("SELECT * FROM crm_tickets_messages_files WHERE message_id = ".$message->id." ORDER BY extension");
      endforeach;
      $chat->count = collect(DB::select("
        SELECT COUNT(stm.id) as count
        FROM crm_tickets_messages stm
        WHERE 1
        $conditions
        LIMIT 1
      "))->first();
      $chat->count = ceil($chat->count->count / $chat->per_page);

      DB::table('crm_tickets_messages')
        ->where('user_id', '!=', $uid)
          ->whereIn('id', collect($chat->list)->pluck('id'))
            ->update(['seen' => 1]);

      return $chat;
    }

    static function build_chat_html($dbp = '', $messages) {
      $_page = collect(DB::select("SELECT `".$dbp."text_62` as text_62 FROM osc_page_profile_order LIMIT 1"))->first(); 
      ob_start();
      foreach($messages as $message):
      if($message->user_id == $message->owner_id): ?>
        <div class="/*animate*/ msg me">
            <div class="avatar" style="background-image: url(<?= url('/public/img/content/default-avatar.jpg') ?>)">
              <img src="<?= url('/public/img/content/default-avatar.jpg') ?>" alt="<?= $message->user_name ?>">
            </div>
            <div class="text"><div class="text-ct"><?= $message->message ?></div></div>
            <div class="footer">
                <span class="name"><?= $_page->text_62 ?></span>
                <span class="date"><?= date('d.m.y', strtotime($message->created)) ?><span class="time"><?= date('H:i', strtotime($message->created)) ?></span></span>
                <span class="files"> 
                      <?php
                  if($message->files):
                    foreach($message->files as $file):
                      echo sprintf('<a class="file-icon hor" target="_blank" title="download" data-type="%s" href="%s"></a>',$file->extension,url('/public/uploads/'.$file->file));
                    endforeach;
                  endif;
                      ?>
                </span>
            </div>
        </div>
      <?php else: ?>
        <div class="/*animate*/ msg">
            <div class="avatar" style="background-image: url(<?= url('/public/img/content/admin-avatar.jpg') ?>)">
              <img src="<?= url('/public/img/content/admin-avatar.jpg') ?>" alt="<?= $message->user_name ?>">
            </div>
            <div class="text"><div class="text-ct"><?= $message->message ?></div></div>
            <div class="footer">
                <span class="name"><?= $message->user_name ?></span>
                <span class="date"><?= date('d.m.y', strtotime($message->created)) ?><span class="time"><?= date('H:i', strtotime($message->created)) ?></span></span>
                <span class="files"> 
                      <?php
                  if($message->files):
                    foreach($message->files as $file):
                      echo sprintf('<a class="file-icon hor" target="_blank" title="download" data-type="%s" href="%s"></a>',$file->extension,url('/public/uploads/'.$file->file));
                    endforeach;
                  endif;
                      ?>
                </span>
            </div>
        </div>
      <?php endif;
      endforeach;
      return ob_get_clean();
    }

    static function get_ticket_status_class($status_id) {
      $class = "";
      switch ($status_id):
        case 1:
          $class = "status-new";
        break;
        case 2:
          $class = "status-pending";
        break;
        case 3:
          $class = "status-canceled";
        break;
        case 4:
          $class = "status-closed";
        break;
        default:
          $class = "status-new";
        break;
      endswitch;
      return $class;
    }

    static function build_pagination($tickets) {
      $res = (object)[];
      ob_start(); ?>
        <?php if ($tickets->count > 1): ?>
          <?php if($tickets->page > 1): ?>
            <a data-page="<?= $tickets->page - 1 ?>" class="item link arrow icon icon-arrow-left5"></a>
          <?php endif; ?>
          <?php if ($tickets->count <= 6): ?>
            <?php for ($i=1; $i < $tickets->count + 1; $i++): ?>
              <a data-page="<?= $i ?>" class="item link <?= ($tickets->page == $i ? 'active' : ''); ?>"><?= $i ?></a>
            <?php endfor ?>
          <?php elseif ($tickets->page <= 2): ?>
            <a data-page="1" class="item link <?= ($tickets->page == 1 ? 'active' : ''); ?>">1</a>
            <a data-page="2" class="item link <?= ($tickets->page == 2 ? 'active' : ''); ?>">2</a>
            <a data-page="3" class="item link <?= ($tickets->page == 3 ? 'active' : ''); ?>">3</a>
            <span class="item dots">...</span>
            <a data-page="<?= $tickets->count ?>" class="item link"><?= $tickets->count ?></a>
          <?php elseif ($tickets->page <= ( $tickets->count - 2 )): ?>
            <a data-page="1" class="item link">1</a></li>
            <span class="item dots">...</span>
            <a data-page="<?= ($tickets->page - 1) ?>" class="item link"><?= ($tickets->page - 1) ?></a>
            <a data-page="<?= $tickets->page ?>" class="item link active"><?= $tickets->page ?></a>
            <a data-page="<?= ($tickets->page + 1) ?>" class="item link"><?= ($tickets->page + 1) ?></a>
            <span class="item dots">...</span>
            <a data-page="<?= $tickets->count ?>" class="item link"><?= $tickets->count ?></a>
          <?php else: ?>
            <a data-page="1" class="item link">1</a>
            <span class="item dots">...</span>
            <a data-page="<?= ($tickets->count-2) ?>" class="item link <?= ($tickets->page == ($tickets->count-2) ? 'active' : ''); ?>"><?= ($tickets->count-2) ?></a>
            <a data-page="<?= ($tickets->count-1) ?>" class="item link <?= ($tickets->page == ($tickets->count-1) ? 'active' : ''); ?>"><?= ($tickets->count-1) ?></a>
            <a data-page="<?= $tickets->count ?>" class="item link <?= ($tickets->page == $tickets->count ? 'active' : ''); ?>"><?= $tickets->count ?></a>
          <?php endif ?>
          <?php if($tickets->page < $tickets->count): ?>
            <a data-page="<?= $tickets->page + 1 ?>" class="item link arrow icon icon-arrow-right5"></a>
          <?php endif; ?>
        <?php elseif($tickets->count > 0): ?>
          <a data-page="1" class="item link <?= ($tickets->page == 1 ? 'active' : ''); ?>">1</a>
        <?php endif; ?>
      <?php
      $res->html = ob_get_clean();
      $res->list = range(1, $tickets->count);
      return $res;
    }

}
