@extends('voyager::master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/css/nestable.css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>目录生成器 ({{ $menu->name }})
        <div class="btn btn-success add_item"><i class="voyager-plus"></i> 新建</div>
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    @include('voyager::menus.partial.notice')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <p class="panel-title" style="color:#777">支持拖放操作</p>
                    </div>

                    <div class="panel-body" style="padding:30px;">

                        <div class="dd">
                            {!! menu($menu->name, 'admin', ['isModelTranslatable' => $isModelTranslatable]) !!}
                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> 确定要删除当前目录吗</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.menus.item.destroy', ['menu' => $menu->id, 'id' => '__id']) }}" id="delete_form"
                          method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="确定删除当前目录">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal modal-success fade" tabindex="-1" id="add_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-plus"></i> 新建</h4>
                </div>
                <form action="{{ route('voyager.menus.item.add', ['menu' => $menu->id]) }}" id="add_form" method="POST">
                    <div class="modal-body">
                        @include('voyager::multilingual.language-selector')
                        <label for="name">标题</label>
                        @include('voyager::multilingual.input-hidden-menu', ['_field_name' => 'add_title', '_field_trans' => ''])
                        <input type="text" class="form-control" id="add_title" name="title" placeholder="Title"><br>
                        <label for="url">地址</label>
                        <input type="text" class="form-control" name="url" placeholder="URL"><br>
                        <label for="icon_class">图标 (Use a <a
                                    href="{{ config('voyager.assets_path') . '/fonts/voyager/icons-reference.html' }}"
                                    target="_blank">Voyager Font Class</a>)</label>
                        <input type="text" class="form-control" name="icon_class"
                               placeholder="Icon Class (optional)"><br>
                        <label for="color">颜色 (选填)</label>
                        <input type="color" class="form-control" name="color"
                               placeholder="Color (ex. #ffffff or rgb(255, 255, 255)"><br>
                        <label for="target">打开方式</label>
                        <select id="edit_target" class="form-control" name="target">
                            <option value="_self">当前窗口</option>
                            <option value="_blank">新建窗口</option>
                        </select>
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                    </div>
                    {{ csrf_field() }}

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm" value="新建">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal modal-info fade" tabindex="-1" id="edit_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-edit"></i> 编辑目录</h4>
                </div>
                <form action="{{ route('voyager.menus.item.update', ['menu' => $menu->id]) }}" id="edit_form" method="POST">
                    {{ method_field("PUT") }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        @include('voyager::multilingual.language-selector')
                        <label for="name">标题</label>
                        @include('voyager::multilingual.input-hidden-menu', ['_field_name' => 'edit_title', '_field_trans' => ''])
                        <input type="text" class="form-control" id="edit_title" name="title" placeholder="Title"><br>
                        <label for="type">链接类型</label>
                        <select id="edit_type" class="form-control" name="type">
                            <option value="url" selected="selected">静态URL</option>
                            <option value="route">动态路由</option>
                        </select><br>
                        <div id="url_type">
                            <label for="url">URL地址</label>
                            <input type="text" class="form-control" id="edit_url" name="url" placeholder="URL"><br>
                        </div>
                        <div id="route_type">
                            <label for="route">路由</label>
                            <input type="text" class="form-control" id="edit_route" name="route" placeholder="Route"><br>
                            <label for="parameters">路由参数 (如果有)</label>
                            <textarea rows="3" class="form-control" id="edit_parameters" name="parameters" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea><br>
                        </div>
                        <label for="icon_class">图标 (Use a <a
                                    href="{{ config('voyager.assets_path') . '/fonts/voyager/icons-reference.html' }}"
                                    target="_blank">Voyager Font Class</a>)</label>
                        <input type="text" class="form-control" id="edit_icon_class" name="icon_class"
                               placeholder="Icon Class (optional)"><br>
                        <label for="color">颜色 (选填)</label>
                        <input type="color" class="form-control" id="edit_color" name="color"
                               placeholder="Color (ex. #ffffff or rgb(255, 255, 255)"><br>
                        <label for="target">打开方式</label>
                        <select id="edit_target" class="form-control" name="target">
                             <option value="_self">当前窗口</option>
                            <option value="_blank">新建窗口</option>
                        </select>
                        <input type="hidden" name="id" id="edit_id" value="">
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm" value="保存">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">取消</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@stop

@section('javascript')

    <script type="text/javascript" src="{{ config('voyager.assets_path') }}/js/jquery.nestable.js"></script>
    @if($isModelTranslatable)
        <script type="text/javascript" src="{{ config('voyager.assets_path') }}/js/multilingual.js"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if ($isModelTranslatable)
                /**
                 * Multilingual setup for main page
                 */
                $('.side-body').multilingual({
                    "transInputs": '.dd-list input[data-i18n=true]'
                });
                /**
                 * Multilingual setup for Add Menu
                 */
                $('#add_modal').multilingual({
                    "form":          'form',
                    "transInputs":   '#add_modal input[data-i18n=true]',
                    "langSelectors": '.language-selector input',
                    "editing":       true
                });
                /**
                 * Multilingual setup for Edit Menu
                 */
                $('#edit_modal').multilingual({
                    "form":          'form',
                    "transInputs":   '#edit_modal input[data-i18n=true]',
                    "langSelectors": '.language-selector input',
                    "editing":       true
                });
            @endif


            $('.dd').nestable({/* config options */});

            /**
             * Delete menu item
             */
            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.currentTarget).data('id');
                $('#delete_form')[0].action = $('#delete_form')[0].action.replace("__id",id);
                $('#delete_modal').modal('show');
            });

            /**
             * Edit menu item
             */
            $('.item_actions').on('click', '.edit', function (e) {
                var id           = $(e.currentTarget).data('id'),
                    translatable = $('#edit_modal').data('multilingual');

                $('#edit_title').val($(e.currentTarget).data('title'));
                $('#edit_url').val($(e.currentTarget).data('url'));
                $('#edit_icon_class').val($(e.currentTarget).data('icon_class'));
                $('#edit_color').val($(e.currentTarget).data('color'));
                $('#edit_route').val($(e.currentTarget).data('route'));
                $('#edit_parameters').val(JSON.stringify($(e.currentTarget).data('parameters')));
                $('#edit_id').val(id);

                // Refresh translatable fields
                if(translatable){
                    $('#edit_title_i18n').val( $("#title" + id + "_i18n").val() );
                    translatable.refresh();
                }

                if ($(e.currentTarget).data('target') == '_self') {
                    $("#edit_target").val('_self').change();
                } else if ($(e.currentTarget).data('target') == '_blank') {
                    $("#edit_target option[value='_self']").removeAttr('selected');
                    $("#edit_target option[value='_blank']").attr('selected', 'selected');
                    $("#edit_target").val('_blank');
                }

                if ($(e.currentTarget).data('route') != "") {
                    $("#edit_type").val('route').change();
                    $("#url_type").hide();
                } else {
                    $("#route_type").hide();
                }

                if ($("#edit_type").val() == 'route') {
                    $("#url_type").hide();
                    $("#route_type").show();
                } else {
                    $("#routel_type").hide();
                    $("#url_type").show();
                }

                $('#edit_modal').modal('show');
            });


            $('.add_item').click(function () {
                var translatable = $('#add_modal').data('multilingual');

                if (translatable) {
                    translatable.refresh();
                }

                $('#add_modal').modal('show');
            });

            /**
             * Reorder items
             */
            $('.dd').on('change', function (e) {
                $.post('{{ route('voyager.menus.order',['menu' => $menu->id]) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("Successfully updated menu order.");
                });

            });

            $('#edit_type').on('change', function (e) {
                if ($("#edit_type").val() == 'route') {
                    $("#url_type").hide();
                    $("#route_type").show();
                } else {
                    $("#routel_type").hide();
                    $("#url_type").show();
                }
            });

        });
    </script>
@stop
