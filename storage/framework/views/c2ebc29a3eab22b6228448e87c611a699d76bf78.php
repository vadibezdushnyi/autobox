<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>crontabs</title>
  </head>
  <style media="screen">
    body a{display: block;
    background: #494949;
    padding: 10px 20px;
    text-decoration: none;
    clear: both;
    min-width: 200px;
    max-width: 400px;
    text-align: center;
    font-family: monospace;
    font-size: 18px;
    color: #ffff80;
    text-shadow: 0 0 20px #ffff80;
    margin: 10px auto;
    transition: all .15s;}
    a:hover{text-shadow: 0 2px 25px #fbfb22;box-shadow: inset 0px 1px 4px 0px #000;}
    a:active{box-shadow: inset 0px -1px 4px 1px #ffff80;}
    body{background: #1a1a1a;}
  </style>
  <body>
    <div style="margin:auto;">
      <a target="_blank" href="<?php echo e(url('/api/syncSendOrders')); ?>">Send Orders</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetOrders')); ?>">Get Orders</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetProducts')); ?>">Get Products</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetProducers')); ?>">Get Producers</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetDiscounts')); ?>">Get Users Discounts</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetDiscountGroups')); ?>">Get Discount Groups</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetDiscountGroupsByProducer')); ?>">Get Discount Groups By Producers </a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetUsers')); ?>">Get Users</a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetUsersInvoices')); ?>">Get Users Invoices </a>
      <a target="_blank" href="<?php echo e(url('/api/syncGetUsersPayments')); ?>">Get Users Payments </a>

      <a target="_blank" href="<?php echo e(url('/api/flushOrders')); ?>" style="background: #810000;">Flush orders</a>
      <a target="_blank" href="<?php echo e(url('/api/flushClients')); ?>" style="background: #810000;">Flush clients</a>
    </div>
  </body>
</html>
