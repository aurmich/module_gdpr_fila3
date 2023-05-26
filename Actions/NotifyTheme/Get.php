<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\NotifyTheme;

use Illuminate\Support\Str;
use Modules\Notify\Models\NotifyTheme;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;

/**
 * -- buildmailmessage ha troppi pezzi simili ..
 */
class Get
{
    use QueueableAction;

    public function execute(string $name, string $type, array $view_params)
    {
        $xot = XotData::make();
        if (! isset($view_params['post_id'])) {
            $view_params['post_id'] = 0;
        }
        if (! isset($view_params['lang'])) {
            $view_params['lang'] = app()->getLocale();
        }

        $theme = NotifyTheme::firstOrCreate([
            'lang' => $view_params['lang'],
            'type' => $type, // email,sms,whatsapp,piccione
            'post_type' => $name,
            'post_id' => $view_params['post_id'], // in questo caso il tipo come register type 3 in cui la pwd e' solo autogenerata
        ]);

        $module_name_low = Str::lower($xot->main_module);

        $trad_mod = $module_name_low.'::'.$type.'.'.$name;

        if (null == $theme->subject) {
            $subject = trans($trad_mod.'.subject');
            $theme->update(['subject' => $subject]);
        }
        if (null == $theme->theme) {
            $theme->update(['theme' => 'ark']);
        }
        if (null == $theme->body_html) {
            $html = trans($trad_mod.'.body_html');
            if (isset($view_params['body_html']) && $html == $trad_mod.'.body_html') {
                $html = '##body_html##';
            }

            // if ('verify-email' == $name && 3 == $view_params['post_id']) {
            //    $html .= '<br/>When you\'ll re-login this will be your password: ##password##';
            // }

            $theme->update(['body_html' => $html]);
        }
        $view_params = array_merge($theme->toArray(), $view_params);

        $body_html = strval($theme->body_html);

        foreach ($view_params as $k => $v) {
            if (is_string($v)) {
                $body_html = Str::replace('##'.$k.'##', $v, $body_html);
            }
        }
        $view_params['body_html'] = $body_html;
    }
}
