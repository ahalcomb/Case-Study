<?
require_once 'Abstract.php';

class Jobs_PaymentDataJob extends Jobs_Abstract {
	
	public function _jobLogic() {

		//include the models
		$transaction_model = new Application_Model_Transactions();

		$transaction_model->importTransactions();

	}
}

$job = new Jobs_PaymentDataJob();
$job->run();
