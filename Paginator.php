<?php
namespace razmik\helper;

class Paginator
{
    public $pageSize = 10;
    
    public $items = [];
    
    public $totalCount;
    
    public $pageParams = [];

    public $currentPage;
    
    public $pageCount = 6;
    
    public $showDisabled = true;
    
    private $_options = [
        'firstChar' => '&laquo;',
        'lastChar' => '&raquo;',
        'defaultItemClass' => 'page-item',
        'defaultLinkClass' => 'page-link',
        'defaultListClass' => 'pagination',
        'queryParam' => 'page'
    ];

    private $_queryParam = 'page';
    
    private $_templatePath = 'templates/pagination.php'; 
    
    public function __construct($params = [])
    { 
        foreach($params as $key => $value) {
            $this->$key = $value;
        }
        
        if (!$this->totalCount) {
            $this->setItems($this->items);
        }

        $currentPage = isset ($_GET[$this->_options['queryParam']]) ? $_GET[$this->_options['queryParam']] : 0;
        $this->setCurrentPage($currentPage);
    }
    
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }
    
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }
    
    public function getCurrentPage()
    {
        return $this->currentPage > 1 ? $this->currentPage : 1;
    }
    
    public function setPageParams($pageParams)
    {
        $this->pageParams = $pageParams;
    }
    
    public function setItems($items)
    {
        $this->items = $items;
        $this->setTotalCount(count($items));
    }
    
    public function notEmpty()
    {
        return count($this->items);
    }
    
    public function itemList()
    {
        $result = [];
        $items = [];
        
        if ($this->items) {
            if (!is_array($this->items)) {
                foreach ($this->items as $el) {
                    $items[] = $el;
                }
                
                $this->items = $items;
            }
            
            $start = $this->getCurrentPage() - 1;
            $result = array_slice($this->items, $start * $this->pageSize, $this->pageSize);
        }

        return $result;
    }
    
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }
    
    public function getPageSize()
    {
        return $this->pageSize;
    }
    
    public function links()
    {
        $totalCount = ceil($this->totalCount / $this->pageSize);
        $currentPage = $this->getCurrentPage();
        $start = 1;

        if ($this->pageCount && $totalCount > $this->pageCount) {
            $start = $currentPage; 
            $total = $start + $this->pageCount - 1;
            
            if ($total < $totalCount) {
                $totalCount = $total;
            } else {
                $start -= $total - $totalCount;
            }
        }

        $options = [
            'currentPage' => $currentPage,
            'totalCount' => $totalCount,
            'url' => Url::current(),
            'start' => $start,
            'showDisabled' => $this->showDisabled
        ];

        $options = array_merge($options, $this->_options);

        return $this->output($options);
    }
    
    private function output($param)
    {
        ob_start();
        
        extract($param, EXTR_SKIP);
        include($this->_templatePath);
        
        $output = ob_get_contents();
        ob_end_clean();
        
        return $output;
    }
}