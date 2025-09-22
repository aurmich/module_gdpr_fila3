<?php

<<<<<<< HEAD
declare(strict_types=1);


return [
    'navigation' => [
        'name' => 'Consensi',
        'plural' => 'Consensi',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Gestione dei consensi privacy',
        ],
        'label' => 'Gestione Consensi',
        'sort' => 62,
        'icon' => 'gdpr-consent',
    ],
    'fields' => [
        'user' => 'Utente',
        'type' => 'Tipo Consenso',
        'status' => 'Stato',
        'date' => 'Data',
        'ip_address' => 'Indirizzo IP',
        'notes' => 'Note',
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
    ],
    'statuses' => [
        'granted' => 'Concesso',
        'denied' => 'Negato',
        'withdrawn' => 'Revocato',
        'expired' => 'Scaduto',
    ],
    'actions' => [
        'grant' => 'Concedi',
        'deny' => 'Nega',
        'withdraw' => 'Revoca',
        'renew' => 'Rinnova',
    ],
];
=======
return array (
  'navigation' => 
  array (
    'name' => 'Consensi',
    'plural' => 'Consensi',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Gestione dei consensi privacy',
    ),
    'label' => 'Gestione Consensi',
    'sort' => 62,
    'icon' => 'gdpr-consent',
  ),
  'fields' => 
  array (
    'user' => 'Utente',
    'type' => 'Tipo Consenso',
    'status' => 'Stato',
    'date' => 'Data',
    'ip_address' => 'Indirizzo IP',
    'notes' => 'Note',
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
  ),
  'statuses' => 
  array (
    'granted' => 'Concesso',
    'denied' => 'Negato',
    'withdrawn' => 'Revocato',
    'expired' => 'Scaduto',
  ),
  'actions' => 
  array (
    'grant' => 'Concedi',
    'deny' => 'Nega',
    'withdraw' => 'Revoca',
    'renew' => 'Rinnova',
  ),
);
>>>>>>> 6d1fb23 (.)
