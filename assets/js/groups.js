/* global yii */

(function ($) {
    yii.groupsPage = {
        selectedFiles: [],
        initEvents: function () {

            /**
             * События нажатия action buttons в списке изображений группы
             */
            $('.storage-groups-view').on('click', '[data-anc="action-button-remove-from-group"]', function () {
                var _this = this;
                BootstrapDialog.show({
                    title: 'Удаление файла из группы',
                    message: 'Изображение будет удалено только из группы, но не из хранилища.<br>Действительно следует удалить?',
                    type: BootstrapDialog.TYPE_WARNING,
                    closable: true,
                    draggable: true,
                    buttons: [{
                            id: 'btn-ok',
                            icon: 'glyphicon glyphicon-trash',
                            label: 'Да',
                            cssClass: 'btn-success',
                            action: function (dialogRef) {
                                $.get(_this.getAttribute('href'), function (d) {
                                    $.pjax.reload({container: '#' + _this.getAttribute('data-pj')});
                                    dialogRef.close();
                                });
                            }
                        }, {
                            id: 'btn-cancel',
                            icon: 'glyphicon glyphicon-collapse-down',
                            label: 'Нет',
                            cssClass: 'btn-default',
                            action: function (dialogRef) {
                                dialogRef.close();
                            }
                        }]
                });
            });
            /*
             * Нажатие табов в панели ресурсов
             */
            $('#source-tab li a').on('click', function () {
                switch (this.getAttribute('href')) {
                    case '#panel-load':
                        break;
                    case '#panel-storage':
                        break;
                    case '#panel-groups':
                        break;
                }
            });
            $('#panel-groups').
                    on('click', '.panel-body.man img', function () {
                        var $this = $(this);
                        $this.toggleClass('selected').sortable({
                            containment: 'window'
                        });
                    });
        }
    };
    $(document).ready(function () {
        yii.groupsPage.initEvents();
        yii.fileListInit();
        $('#accordion').on('shown.bs.collapse', function () {
            try {
                var acc = $(this).find('[aria-expanded="true"]').get(0);
                $.get('group-thumbs', {id: acc.getAttribute('data-groupid')}, function (d) {
                    acc.parentNode.parentNode.parentNode.children[1].children[0].innerHTML = d;
                    $(acc.parentNode.parentNode.parentNode.children[1].children[0]).sortable({
                        placeholder: "ui-state-highlight"
                    });
                });
            } catch (e) {
            }
        });
    });
    $(document).on('pjax:success', function () {
        yii.fileListInit();
    });
    yii.fileListInit = function () {
        $('#gi table tbody').sortable({
            placeholder: "ui-state-highlight",
            start: function () {

            },
            update: function (e, ui) {
                var ids = [];
                var body = ui.item.get(0).parentNode;
                for (var i = 0; i < body.children.length; i++) {
                    ids.push(body.children[i].getAttribute('data-key'));
                }
                console.log(ids);
            }
        });
        $('#gi table tbody').disableSelection();
    }
})(jQuery);