<?php

use yii\helpers\Html;

date_default_timezone_set('Etc/GMT-4');

$this->registerJsFile('/js/blogView.js');

?>
<div class="well">
    <div class=" well" style="background-color:#34363a; color: white;">
        <div class="row">
            <div class="col-sm-1"><h3>Name</h3></div>
            <div class="col-sm-1"><h3>Date</h3></div>
            <div class="col-sm-1"><h3>Comment</h3></div>
        </div>
    </div>
    <?php
    /** @var TYPE_NAME $displayComment */
    foreach ($displayComment as $item) : ?>
        <div class="well" id="com<?php echo $item->id; ?>">
            <div class="row" onclick="editComment(event)">
                <div class="col-sm-1">
                    <a href="index?userId=<?php echo $item->user->id;?>"><h5><?php echo $item->user->getFullName() ?></h5></a>
                </div>
                <div class="col-sm-1">
                    <?php echo date("Y.d.m H:i:s", $item->created_at); ?>
                </div>
                <div class="col-sm-9">
                    <div id="comment<?php echo $item->id; ?>"><?php echo $item->comment ?></div>
                </div>
                <?php if (Yii::$app->user->id === $item->user_id): ?>
                    <p id="id<?php echo $item->id; ?>" style="display: none"><?php echo $item->id; ?></p>
                    <span class="btn btn-primary btn-xs" id="edit<?php echo $item->id; ?>">Edit</span>
                    <span class="btn btn-danger btn-xs" id="delete<?php echo $item->id; ?>">Delete</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

