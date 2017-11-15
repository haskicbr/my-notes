<?php
	namespace Crm\Classes\Statistics;

	use Crm\BusyInterval;
	use Crm\Classes\Statistics\Abstracts\AbstractStatistics;
	use Crm\OrderInterval;
	use Crm\PaymentTypeVariant;
	use Crm\Repositories\BusyIntervalRepository;
	use Crm\Repositories\OrderIntervalRepository;

	class BusyIntervalsStatistics extends AbstractStatistics {
		const NAME = 'Отчет: загруженность интервалов';
		const VIEW_ON_INDEX = 0;

		protected $intervalId;

		protected function init() {
			parent::init();

			$this->intervalId = $this->request->get('interval', 0);
			$this->result['message'] = 'Нет результатов';
		}

		public function getPage() {
			parent::getPage();

			$this->result['intervals'] = app(OrderIntervalRepository::class)->getOrdersByRevision();

			return $this->result;
		}

		public function getData() {
			$result['busyIntervals'] = app(BusyIntervalRepository::class)
				->getBusyIntervalsForCityAndInterval($this->cityId, $this->intervalId);

			if ($result['busyIntervals']->isEmpty()) return parent::getData();

			$this->result['status'] = 'ok';
			$this->result['data'] = $result['busyIntervals'];

			return $this->result;
		}
	}
