<?php

use yii\helpers\Html;

$size = sizeof($model);
$pages = intval($size / 2) + intval($size % 2);
?>
    <style>
        span.media-heading {
            font-size: 30px;
            color: black;
        }

        a:hover {
            text-decoration-line: none;
        }
    </style>
    <div style="margin:0 auto; text-align: center;">
        <ul class="pagination">
            <?php if ($index <= 0): ?>
                <li class="page-item disabled"><a class="page-link"> < </a></li>
            <?php else: ?>
                <li class="page-item">
                    <?php echo Html::a(
                        '<',
                        ['blog/index',
                            'index' => $index - 1,
                            'userId' => $userId,
                        ],
                        ['class' => 'profile-link']);
                    ?>
                </li>
            <?php endif; ?>
            <?php for ($i = 0; $i < $pages; $i++): ?>
                <li class="page-item">
                    <?php echo Html::a(
                        $i + 1,
                        ['blog/index',
                            'index' => $i,
                            'userId' => $userId,
                        ],
                        ['class' => 'profile-link']);
                    ?>
                </li>
            <?php endfor; ?>
            <?php if ($index + 1 === $pages): ?>
                <li class="page-item disabled"><a class="page-link"> > </a></li>
            <?php else: ?>
                <li class="page-item">
                    <?php echo Html::a(
                        '>',
                        ['blog/index',
                            'index' => $index + 1,
                            'userId' => $userId,
                        ],
                        ['class' => 'profile-link']);
                    ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="container">
        <div class="well">
            <?php /** @var TYPE_NAME $model */
            $index++;
            if (isset($model[$index * 2 - 1])) {
                $nextRows = 0;
            } else {
                $nextRows = 1;
            }
            for ($i = $index * 2 - 2; $i < $index * 2 - $nextRows; $i++): ?>
                <div class="well">
                    <div class="media">
                        <?php echo Html::a(
                            Html::img(
                                $model[$i]->getImage(),
                                [
                                    'height' => '150px',
                                    'width' => '150px',
                                    'class' => 'media-object',
                                ]
                            ),
                            ['blog/view',
                                'id' => $model[$i]->id,
                            ],
                            ['class' => 'pull-left']);
                        ?>
                        <div class="media-body">
                            <?php echo Html::a(
                                "<span class='media-heading'>" . $model[$i]->title . '</span>',
                                ['blog/view',
                                    'id' => $model[$i]->id,
                                ]);
                            ?>
                            <p><?php echo $model[$i]->short_description; ?></p>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
<?php $this->registerJsFile('/js/blogView.js'); ?>