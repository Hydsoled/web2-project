<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2/5/19
 * Time: 3:13 PM
 */

/**
 * @var $notes \frontend\models\Note[]
 */
$chunkedNotes = array_chunk($notes, 3);
?>

<?php foreach ($chunkedNotes as $innerArr): ?>
    <div class="row">
        <?php foreach ($innerArr as $note): ?>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <?php echo $note->title ?>
                    </div>
                    <div class="panel-body">
                        <?php echo $note->body ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
<?php //for ($i = 0; $i < intval(count($notes) / 3) + ( (count($notes) % 3 > 0) ? 1 : 0 ); $i++): ?>
<!--    <div class="row">-->
<!--        --><?php //for (; $j < sizeof($notes); $j++): ?>
<!--            <div class="col-sm-4">-->
<!--                <div class="panel panel-success">-->
<!--                    <div class="panel-heading">-->
<!--                        --><?php //echo $notes[$j]->title ?>
<!--                    </div>-->
<!--                    <div class="panel-body">-->
<!--                        --><?php //echo $notes[$j]->body ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php //endfor; ?>
<!--    </div>-->
<?php //endfor; ?>
