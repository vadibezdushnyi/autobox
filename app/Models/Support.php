<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Storage;

class Support extends Model
{
    protected $table = 'crm_support_tickets';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [

    ];
    protected $guarded = [
        'block',
        'order_id',
    ];
    protected $hidden = [
        'block',
        'order_id',
    ];

    static function upload_files($files, $message_id) {
      if($files):
        foreach($files as $file):
          if(self::sanitizefile($file)):
            $filename = $file->store('', 'uploads');
            $extension = $file->extension();
            DB::table('crm_tickets_messages_files')->insert([
              'message_id' => $message_id,
              'file' => $filename,
              'extension' => $extension,
            ]);
          endif;
        endforeach;
      endif;
      return true;
    }

    static function sanitizefile($file) {
      $accepted = ['doc','docx','xls','xlsx','csv','pdf','txt','jpg','jpeg','png','gif','php','js','html','xml'];
      return in_array($file->extension(), $accepted);
    }

    static function add_new_message(int $ticket_id, array $request) {
      return DB::table('crm_tickets_messages')->insertGetId([
        'ticket_id' => $ticket_id,
        'user_id' => $request['user_id'],
        'message' => $request['message'],
      ]);
    }

    static function get_status_name(string $dbp = '', int $status_id) {
      $status = collect(DB::select("SELECT ".$dbp."name as name FROM crm_tickets_statuses WHERE id = $status_id LIMIT 1"))->first();
      return $status ? $status->name : null;
    }

    static function get_ticket(string $dbp = '', $ticket) {
      $uid = Session::get('user_id');
      $ticket = collect(DB::select("
        SELECT o.*,
        (SELECT ".$dbp."name as name FROM crm_tickets_statuses WHERE id = o.status_id LIMIT 1) as status_name,
        (SELECT COUNT(id) FROM crm_tickets_messages WHERE ticket_id = o.id LIMIT 1) as messages_count
        FROM crm_orders o
        WHERE o.id = '$ticket'
        AND o.user_id = $uid
        AND o.removed = 0
        LIMIT 1
      "))->first();
      if($ticket):
        $ticket->messages = DB::select("SELECT * FROM crm_tickets_messages WHERE ticket_id = $ticket->id ORDER BY id DESC LIMIT 5");
      endif;
      return $ticket;
    }

    static function get_chat(string $dbp = '', $filters = null) {
      $uid = Session::get('user_id');
      $chat = (object)[];
      $chat->per_page = 5;
      $chat->page = 1;
      $limit = "LIMIT 0, " . $chat->per_page;
      $conditions = "";
      $sorting = "ORDER BY stm.id DESC";
      if($filters):
        if($filters->sorting) $sorting = self::get_chat_sorting($filters->sorting);
        if($filters->ticket) $conditions .= " AND stm.ticket_id = $filters->ticket";
        if($chat->page = $filters->page) $limit =  "LIMIT " . ( $chat->page * $chat->per_page - $chat->per_page ) . ", " . $chat->per_page;
      endif;
      $chat->list = DB::select("
        SELECT stm.*,
        (SELECT user_id FROM crm_tickets WHERE crm_id = stm.order_id LIMIT 1) as owner_id
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

    static function build_chat_html($messages, $_page) {
      ob_start();
      foreach($messages as $message):
      if($message->user_id == $message->owner_id): ?>
        <div class="/*animate*/ msg me">
            <div class="avatar" style="background-image: url(<?= url('/public/assets/img/content/default-avatar.jpg') ?>)">
              <img src="<?= url('/public/assets/img/content/default-avatar.jpg') ?>" alt="<?= $message->user_name ?>">
            </div>
            <div class="text"><div class="text-ct"><?= $message->message ?></div></div>
            <div class="footer">
                <span class="name"><?= $_page->text_18 ?></span>
                <span class="date"><?= date('d.m.y', strtotime($message->created)) ?><span class="time"><?= date('H:i', strtotime($message->created)) ?></span></span>
                <span class="files"> 
                      <?php
                  if($message->files):
                    foreach($message->files as $file):
                      echo sprintf('<a class="file-icon hor" title="download" data-type="%s" download href="%s"></a>',$file->extension,url('/public/storage/'.$file->file));
                    endforeach;
                  endif;
                      ?>
                </span>
            </div>
        </div>
      <?php else: ?>
        <div class="/*animate*/ msg">
            <div class="avatar" style="background-image: url(<?= url('/public/assets/img/content/admin-avatar.jpg') ?>)">
              <img src="<?= url('/public/assets/img/content/admin-avatar.jpg') ?>" alt="<?= $message->user_name ?>">
            </div>
            <div class="text"><div class="text-ct"><?= $message->message ?></div></div>
            <div class="footer">
                <span class="name"><?= $message->user_name ?></span>
                <span class="date"><?= date('d.m.y', strtotime($message->created)) ?><span class="time"><?= date('H:i', strtotime($message->created)) ?></span></span>
                <span class="files"> 
                      <?php
                  if($message->files):
                    foreach($message->files as $file):
                      echo sprintf('<a class="file-icon hor" title="download" data-type="%s" download href="%s"></a>',$file->extension,url('/public/storage/'.$file->file));
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
