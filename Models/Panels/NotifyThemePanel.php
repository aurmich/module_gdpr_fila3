<?php

namespace Modules\Notify\Models\Panels;

use Illuminate\Http\Request;
use Modules\Xot\Contracts\RowsContract;
//--- Services --

use Modules\Xot\Models\Panels\XotBasePanel;

class NotifyThemePanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = 'Modules\Notify\Models\NotifyTheme';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'title';



    /**
     * Get the fields displayed by the resource.
     *
     * @return array
        'col_size' => 6,
        'sortable' => 1,
        'rules' => 'required',
        'rules_messages' => ['it'=>['required'=>'Nome Obbligatorio']],
        'value'=>'..',
     */
    public function fields(): array {
        return array (
  
  (object) array(
     'type' => 'Id',
     'name' => 'id',
     'comment' => NULL,
  ),
  
  (object) array(
     'type' => 'String',
     'name' => 'lang',
     'comment' => NULL,
<<<<<<< HEAD
     'col_size' =>3
=======
>>>>>>> 42aa20e (.)
  ),
  
  (object) array(
     'type' => 'String',
     'name' => 'type',
     'comment' => NULL,
<<<<<<< HEAD
     'col_size' =>3
  ),
  (object) array(
    'type' => 'String',
    'name' => 'from',
    'comment' => NULL,
    'col_size' =>3
 ),
=======
  ),
>>>>>>> 42aa20e (.)
  
  (object) array(
     'type' => 'String',
     'name' => 'subject',
     'comment' => NULL,
<<<<<<< HEAD
     'col_size' =>12
  ),

  (object) array(
    'type' => 'Textarea',
    'name' => 'body',
    'comment' => NULL,
    'except'=>['index'],
 ),

  (object) array(
     'type' => 'WysiwygSceditor',
     'name' => 'body_html',
     'comment' => NULL,
     'except'=>['index'],
=======
  ),
  
  (object) array(
     'type' => 'WysiwygSummerNote',
     'name' => 'body',
     'comment' => NULL,
>>>>>>> 42aa20e (.)
  ),
);
    }

    /**
     * Get the tabs available.
     *
     * @return array
     */
    public function tabs():array {
        $tabs_name = [];

        return $tabs_name;
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request):array {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request = null):array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request):array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions():array {
        return [];
    }
}
