<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Otp;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Session\SessionManager;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
class AuthIndex extends Action
{
    public $resultPageFactory;
    protected $_storageSession;
    protected $_helperData;
    public function __construct(Context $bD_cj, PageFactory $Wc8xU, SessionManager $l1i92)
    {
        $this->resultPageFactory = $Wc8xU;
        $this->_storageSession = $l1i92;
        parent::__construct($bD_cj);
    }
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
    protected function _isAllowed()
    {
        return (bool) $this->_storageSession->getData("\165\163\x65\162");
    }
}