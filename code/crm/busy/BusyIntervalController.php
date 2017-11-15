<?php


	namespace Crm\Http\Controllers\Crm;

	use Crm\BusyInterval;
	use Crm\Classes\Statistics\BusyIntervalsStatistics;
	use Crm\Http\Controllers\CrmController;
	use Crm\Http\Requests\CreateBusyIntervalRequest;
	use Crm\Repositories\CityRepository;
	use Crm\Repositories\OrderIntervalRepository;

	class BusyIntervalController extends CrmController {
		public $actionMenu;

		public function __construct() {
			parent::__construct();

			$this->middleware('auth');

			$this->actionMenu = [
				\URL::action('Crm\BusyIntervalController@getIndex') => 'Список',
				\URL::action('Crm\BusyIntervalController@getAdd')   => 'Добавить',
			];

			view()->share('actionMenu', $this->actionMenu);
		}

		public function getIndex(BusyIntervalsStatistics $statistics) {
			return $statistics->renderPage();
		}

		public function postIndex(BusyIntervalsStatistics $statistics) {
			return $statistics->renderData();
		}

		public function getAdd() {
			$data['cities'] = app(CityRepository::class)->getAll();
			$data['order_intervals'] = app(OrderIntervalRepository::class)->getOrdersByRevision();

			return view('crm.admin.busyInterval.form', $data);
		}


		public function postAdd(CreateBusyIntervalRequest $request) {
			$busy = BusyInterval::where('city_id', $request->get('city_id'))
				->where('order_interval_id', $request->get('order_interval_id'))
				->first();

			$busy = $busy ?? new BusyInterval();

			$busy->fill($request->all())->save();

			return redirect()->action('Crm\BusyIntervalController@getEdit', [$busy->id]);
		}

		public function getEdit($id) {
			$data['cities'] = app(CityRepository::class)->getAll();
			$data['order_intervals'] = app(OrderIntervalRepository::class)->getOrdersByRevision();
			$data['interval'] = BusyInterval::findOrFail($id);

			return view('crm.admin.busyInterval.form', $data);
		}

		public function postEdit(CreateBusyIntervalRequest $request) {
			$busy = BusyInterval::where('city_id', $request->get('city_id'))
				->where('order_interval_id', $request->get('order_interval_id'))
				->first();

			$busy = $busy ?? new BusyInterval();

			$busy->fill($request->all())->save();

			return redirect()->action('Crm\BusyIntervalController@getEdit', [$busy->id]);
		}

		public function postDelete($id) {
			$interval = BusyInterval::findOrFail($id);
			$interval->delete();

			return redirect()->action('Crm\BusyIntervalController@getIndex');
		}
	}


