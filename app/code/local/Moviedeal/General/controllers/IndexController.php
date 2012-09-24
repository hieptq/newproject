<?php
    class Moviedeal_General_IndexController extends Mage_Core_Controller_Front_Action
    {
        /**
         * Retrieve customer session model object
         *
         * @return Mage_Customer_Model_Session
         */
        protected function _getSession()
        {
            return Mage::getSingleton('customer/session');
        }
    
        public function indexAction()
        {             

            $session = $this->_getSession();
            
            if ($this->getRequest()->isPost()) {
                $errors = array();
    
                if (!$customer = Mage::registry('current_customer')) {
                    $customer = Mage::getModel('customer/customer')->setId(null);
                }
    
                $name = $this->getRequest()->getPost('account_name');
                $name_parts = explode(' ', $name);
				if(count($name_parts) > 1){
					$firstname = $name_parts[0];
					$lastname = $name_parts[1];
				}
				else{
					$firstname = $name;
					$lastname = '.';
				}
                
                
                $email = $this->getRequest()->getPost('account_email');
                
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);
                $customer->setEmail($email);
				$newPassword = $customer->generatePassword(8);

                $customer->setPassword($newPassword);
				
                $customer->setConfirmation($newPassword);
				//print_r($customer->getData());die;
                /**
                 * Initialize customer group id
                 */
                $customer->getGroupId();
    
                try {
                    //$randomPassword = $this->_getRandomStringPassword(8);
					
					//$customer->setConfirmation($randomPassword);
                    
                    $customerErrors = $customer->validate();
                    if (is_array($customerErrors)) {
                        $errors = array_merge($customerErrors, $errors);
                    }
    
                    $validationResult = count($errors) == 0;
    
                    if (true === $validationResult) {
                        $customer->save();
						//$customer->sendNewAccountEmail();
                        if ($customer->isConfirmationRequired()) {
                            $customer->sendNewAccountEmail('confirmation', $session->getBeforeAuthUrl());
                            Mage::getSingleton('core/session')->addSuccess($this->__('Account confirmation is required. Please, check your email for the confirmation link. To resend the confirmation email please <a href="%s">click here</a>.', Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail())));
                            //$this->_redirectSuccess(Mage::getUrl('customer/account/index', array('_secure'=>true)));
                            $this->_redirectReferer();
							return;
                        } else {
                            $session->setCustomerAsLoggedIn($customer);
                            //$customer->sendNewAccountEmail('registered');
                            $url = $this->_welcomeCustomer($customer);
                            $this->_redirectSuccess($url);
							$this->_redirectReferer();
                            return;
                        }
                    } else {
                        $session->setCustomerFormData($this->getRequest()->getPost());
                        if (is_array($errors)) {
                            foreach ($errors as $errorMessage) {
                                $session->addError($errorMessage);
                            }
                        } else {
                            Mage::getSingleton('core/session')->addError($this->__('Invalid customer data'));
                        }
                    }
                } catch (Mage_Core_Exception $e) {
                    $session->setCustomerFormData($this->getRequest()->getPost());
                    if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
                        $url = Mage::getUrl('customer/account/forgotpassword');
                        $message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
						//$session->setEscapeMessages(false);
                    } else {
                        $message = $e->getMessage();
                    }
                    Mage::getSingleton('core/session')->addError($message);
                } catch (Exception $e) {
                    $session->setCustomerFormData($this->getRequest()->getPost())
                        ->addException($e, $this->__('Cannot save the customer.'));
                }
            }
			$this->_redirectReferer();
            //$this->_redirectError(Mage::getBaseUrl());  
        }
        
        /**
         * Add welcome message and send new account email.
         * Returns success URL
         *
         * @param Mage_Customer_Model_Customer $customer
         * @param bool $isJustConfirmed
         * @return string
         */
        protected function _welcomeCustomer(Mage_Customer_Model_Customer $customer, $isJustConfirmed = false)
        {
            $this->_getSession()->addSuccess(
                $this->__('Thank you for registering with %s.', Mage::app()->getStore()->getFrontendName())
            );
    
            $customer->sendNewAccountEmail($isJustConfirmed ? 'confirmed' : 'registered');
            
            $successUrl = Mage::getUrl('customer/account/index', array('_secure'=>true));
            
            return $successUrl;
        }
        
        private function _getRandomStringPassword($length)
        {
            $str = '';
            $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            
            $count = strlen($charset);
            while ($length--) {
                $str .= $charset[mt_rand(0, $count-1)];
            }
            return $str;
        }
    }