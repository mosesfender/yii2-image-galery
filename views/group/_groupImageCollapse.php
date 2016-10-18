<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
    foreach ($modelGroupList as $group):
        /* @var $group \mosesfender\galery\models\StorageGroups */
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="panel_group<?php echo $group->id; ?>">
                <h4 class="panel-title">
                    <a data-groupid="<?php echo $group->id; ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#group<?php echo $group->id; ?>" aria-expanded="true" aria-controls="group<?php echo $group->id; ?>"><?php echo $group->title; ?></a>
                </h4>
            </div>
            <div data-groupid="<?php echo $group->id; ?>" id="group<?php echo $group->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="panel_group<?php echo $group->id; ?>">
                <div class="panel-body man"></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>