<?php

namespace MiniOrange\TwoFA\Controller\Adminhtml\Upgrade;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use MiniOrange\TwoFA\Controller\Actions\BaseAdminAction;
use MiniOrange\TwoFA\Helper\TwoFAConstants;
class Index extends BaseAdminAction implements HttpGetActionInterface
{
    public function execute()
    {
        try {
            $p4_LS = $this->twofautility->getCurrentAdminUser()->getEmail();
            $this->twofautility->isFirstPageVisit($p4_LS, "\x55\160\147\x72\x61\x64\145");
        } catch (\Exception $LrJSc) {
            $this->messageManager->addErrorMessage($LrJSc->getMessage());
            $this->logger->debug($LrJSc->getMessage());
        }
        $V8k3d = $this->resultPageFactory->create();
        $V8k3d->getConfig()->getTitle()->prepend(__(TwoFAConstants::MODULE_TITLE));
        return $V8k3d;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(TwoFAConstants::MODULE_DIR . TwoFAConstants::MODULE_UPGRADE);
    }
}