<?php
/**
 * Created by PhpStorm.
 * User: Star
 * Date: 12/6/2017
 * Time: 6:16 AM
 */
?>
<html>
<head>
    <title>Insert Data Into Database Using CodeIgniter Form</title>
    <link href='http://fonts.googleapis.com/css?family=Marcellus' rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" type="text/css" href="<?php echo config_item('base_url'); ?>css/style.css" />
</head>
<body>

<div id="container">
    <?php echo form_open('insert_ctrl'); ?>
    <h1>Insert Data Into Database Using CodeIgniter</h1><hr/>
    <?php if (isset($message)) { ?>
        <CENTER><h3 style="color:green;">Data inserted successfully</h3></CENTER><br>
    <?php } ?>
    <?php echo form_label('Student Name :'); ?> <?php echo form_error('dname'); ?><br />
    <?php echo form_input(array('id' => 'dname', 'name' => 'dname')); ?><br />

    <?php echo form_label('Student Email :'); ?> <?php echo form_error('demail'); ?><br />
    <?php echo form_input(array('id' => 'demail', 'name' => 'demail')); ?><br />

    <?php echo form_label('Student Mobile No. :'); ?> <?php echo form_error('dmobile'); ?><br />
    <?php echo form_input(array('id' => 'dmobile', 'name' => 'dmobile', 'placeholder' => '10 Digit Mobile No.')); ?><br />

    <?php echo form_label('Student Address :'); ?> <?php echo form_error('daddress'); ?><br />
    <?php echo form_input(array('id' => 'daddress', 'name' => 'daddress')); ?><br />

    <?php echo form_submit(array('id' => 'submit', 'value' => 'Submit')); ?>
    <?php echo form_close(); ?><br/>
    <div id="fugo">

    </div>
</div>
</body>
</html>
