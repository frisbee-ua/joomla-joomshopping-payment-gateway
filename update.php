<?php
$db = JFactory::getDBO();
$query = 'describe `#__jshopping_payment_method`';
$db->setQuery($query);
$tableColumns = $db->loadObjectList();

$values = [
    'payment_code' => $db->quoteName('Frisbee'),
    'payment_class' => $db->quoteName('pm_frisbee'),
    'scriptname' => $db->quoteName('pm_frisbee'),
    'payment_publish' => 1,
    'payment_ordering' => 0,
    'payment_type' => 2,
    'price' => 0.00,
    'price_type' => 1,
    'tax_id' => -1,
    'show_descr_in_email' => 0,
    'name_en-GB' => $db->quoteName('Frisbee'),
    'description_en-GB' => $db->quoteName('Frisbee Payment Service'),
    'name_de-DE' => $db->quoteName('Frisbee'),
    'description_de-DE' => $db->quoteName('Frisbee Payment Service')
];

$possibleValues = [
    'name_ru-RU' => 'Сервис оплаты частями',
    'description_ru-RU' => 'Сервис оплаты частями',
    'name_uk-UA' => 'Сервіс оплати частинами',
    'description_uk-UA' => 'Сервіс оплати частинами',
];
$possibleColumns = array_keys($possibleValues);

foreach ($tableColumns as $column) {
    if (in_array($column->Field, $possibleColumns)) {
        $values[$column->Field] = $db->quoteName($possibleValues[$column->Field]);
        echo $column->Field . "\n";
    }
}

$query = $db->getQuery(true);

$query
    ->insert($db->quoteName('#__jshopping_payment_method'))
    ->columns($db->quoteName(array_keys($values)))
    ->values(str_replace('`', '\'', implode(',', $values)));

$db->setQuery($query);
$result = $db->execute();
