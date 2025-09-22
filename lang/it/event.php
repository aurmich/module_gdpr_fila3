<?php

<<<<<<< HEAD
declare(strict_types=1);


return [
    'navigation' => [
        'name' => 'Eventi Privacy',
        'plural' => 'Eventi Privacy',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Registro degli eventi relativi alla privacy',
        ],
        'label' => 'Eventi Privacy',
        'sort' => 27,
        'icon' => 'gdpr-event',
    ],
    'fields' => [
        'event_type' => 'Tipo Evento',
        'description' => 'Descrizione',
        'user' => 'Utente',
        'timestamp' => 'Data e Ora',
        'data' => 'Dati',
        'source' => 'Sorgente',
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'event_types' => [
        'consent_granted' => 'Consenso Concesso',
        'consent_withdrawn' => 'Consenso Revocato',
        'data_access' => 'Accesso ai Dati',
        'data_modified' => 'Dati Modificati',
        'data_deleted' => 'Dati Eliminati',
    ],
];
=======
return array (
  'navigation' => 
  array (
    'name' => 'Eventi Privacy',
    'plural' => 'Eventi Privacy',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Registro degli eventi relativi alla privacy',
    ),
    'label' => 'Eventi Privacy',
    'sort' => 27,
    'icon' => 'gdpr-event',
  ),
  'fields' => 
  array (
    'event_type' => 'Tipo Evento',
    'description' => 'Descrizione',
    'user' => 'Utente',
    'timestamp' => 'Data e Ora',
    'data' => 'Dati',
    'source' => 'Sorgente',
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
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
  ),
  'event_types' => 
  array (
    'consent_granted' => 'Consenso Concesso',
    'consent_withdrawn' => 'Consenso Revocato',
    'data_access' => 'Accesso ai Dati',
    'data_modified' => 'Dati Modificati',
    'data_deleted' => 'Dati Eliminati',
  ),
);
>>>>>>> 6d1fb23 (.)
