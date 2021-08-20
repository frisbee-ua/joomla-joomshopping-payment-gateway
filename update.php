<?php

class ExtensionInstaller
{
    protected $db;
    
    public function __construct() 
    {
        $this->db = JFactory::getDBO();
    }

    public function install() 
    {
        if (!$this->getPaymentMethodFrisbee()) {
            $this->createPaymentMethodFrisbee();
        }
        
        if (!$this->getStatusDeclined()) {
            $this->createStatusDeclined();
        }
    }

    protected function describeTable($table) 
    {
        $query = sprintf('describe `%s`', $table);
        $this->db->setQuery($query);

        return $this->db->loadObjectList();
    }

    protected function getPaymentMethodFrisbee() 
    {
        $query = 'select * from `#__jshopping_payment_method` where payment_class = \'pm_frisbee\'';
        $this->db->setQuery($query);

        return $this->db->loadObject();
    }

    protected function createPaymentMethodFrisbee() 
    {
        $tableColumns = $this->describeTable('#__jshopping_payment_method');
        
        $values = [
            'payment_code' => $this->db->quoteName('Frisbee'),
            'payment_class' => $this->db->quoteName('pm_frisbee'),
            'scriptname' => $this->db->quoteName('pm_frisbee'),
            'payment_publish' => 1,
            'payment_ordering' => 0,
            'payment_type' => 2,
            'price' => 0.00,
            'price_type' => 1,
            'tax_id' => -1,
            'show_descr_in_email' => 0,
            'name_en-GB' => $this->db->quoteName('Frisbee'),
            'description_en-GB' => $this->db->quoteName('Frisbee Payment Service'),
            'name_de-DE' => $this->db->quoteName('Frisbee'),
            'description_de-DE' => $this->db->quoteName('Frisbee Payment Service')
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
                $values[$column->Field] = $this->db->quoteName($possibleValues[$column->Field]);
            }
        }

        $query = $this->db->getQuery(true);
        $query
            ->insert($this->db->quoteName('#__jshopping_payment_method'))
            ->columns($this->db->quoteName(array_keys($values)))
            ->values(str_replace('`', '\'', implode(',', $values)));

        $this->db->setQuery($query);
        $this->db->execute();
    }
    
    protected function getStatusDeclined()
    {
        $query = 'select * from `#__jshopping_order_status` where status_code = \'D\'';
        $this->db->setQuery($query);

        return $this->db->loadObject();
    }

    protected function createStatusDeclined() 
    {
        $tableColumns = $this->describeTable('#__jshopping_order_status');

        $values = [
            'status_code' => $this->db->quoteName('D'),
            'name_en-GB' => $this->db->quoteName('Declined'),
            'name_de-DE' => $this->db->quoteName('Declined'),
        ];

        $possibleValues = [
            'name_ru-RU' => 'Отклоненный',
            'name_uk-UA' => 'Відхилено',
        ];
        $possibleColumns = array_keys($possibleValues);

        foreach ($tableColumns as $column) {
            if (in_array($column->Field, $possibleColumns)) {
                $values[$column->Field] = $this->db->quoteName($possibleValues[$column->Field]);
            }
        }

        $query = $this->db->getQuery(true);
        $query
            ->insert($this->db->quoteName('#__jshopping_order_status'))
            ->columns($this->db->quoteName(array_keys($values)))
            ->values(str_replace('`', '\'', implode(',', $values)));

        $this->db->setQuery($query);
        $this->db->execute();
    }
}

$extensionInstaller = new ExtensionInstaller();
$extensionInstaller->install();
