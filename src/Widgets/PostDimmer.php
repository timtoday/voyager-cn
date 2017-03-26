<?php

namespace TCG\Voyager\Widgets;

use Arrilot\Widgets\AbstractWidget;
use TCG\Voyager\Facades\Voyager;

class PostDimmer extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Voyager::model('Post')->count();
        $string = $count == 1 ? '帖子' : '帖子';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-group',
            'title'  => "{$count} {$string}",
            'text'   => "当前共有 {$count} 条{$string}数据.",
            'button' => [
                'text' => '查看所有帖子',
                'link' => route('voyager.posts.index'),
            ],
            'image' => url(config('voyager.assets_path').'/images/widget-backgrounds/03.png'),
        ]));
    }
}
