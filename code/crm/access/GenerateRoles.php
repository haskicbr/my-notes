<?php

	namespace Crm\Console\Commands\Crm\UserRole;

	use Carbon\Carbon;
	use Crm\Console\Commands\BaseCommand;
	use Crm\Repositories\UserRoleRepository;
	use Illuminate\Support\Collection;

	class GenerateRoles extends BaseCommand {
		protected $signature = 'crm:user-role:generate';

		protected $description = 'Автоматическое создание ролей пользователей...';

		/**
		 * @var array
		 */
		protected $roles = [];

		/**
		 * @var Collection
		 */
		protected $existsRoles;

		/**
		 * @var string
		 */
		protected $now;

		/**
		 * @return void
		 */
		public function handle() {
			$this->line($this->description);

			$this->now = Carbon::now()->toDateTimeString();

			$this
				->setExistsRoles()
				->setStatisticRoles()
				->setModelRoles()
				->separateRoles()
				->insertRoles()
				->updateRoles();

			$updateCount = count($this->roles['update'] ?? []);
			$createCount = count($this->roles['create'] ?? []);
			$noChange = count($this->roles['no_change'] ?? []);

			$this->line('Добавлено:' . $createCount);
			$this->line('Обновлено:' . $updateCount);
			$this->line('Не изменилось:' . $noChange);
		}

		/**
		 * @return $this
		 */
		protected function setExistsRoles() {
			$this->existsRoles = app(UserRoleRepository::class)->getListForGenerate();

			return $this;
		}

		/**
		 * @return $this
		 */
		protected function setModelRoles() {
			$this->setRoles(app_path(), 'Crm\\');

			return $this;
		}

		/**
		 * @return $this
		 */
		protected function setStatisticRoles() {
			$this->setRoles(app_path('Classes/Statistics'), 'Crm\\Classes\\Statistics\\');

			return $this;
		}


		/**
		 * @return $this
		 */
		protected function setRoles($path, $namespace) {
			$this
				->getReflectionList($path, $namespace)
				->map(function (\ReflectionClass $class) {
					$aliasName = $class->getConstant('NAME');
					$className = lcfirst($class->getShortName());

					$roles = $class->getConstant('BASE_ROLES');
					$extendRoles = $class->getConstant('EXTEND_ROLES');
					$extendRoles = $extendRoles ? $extendRoles : [];

					try {
						$roles = array_merge($roles, $extendRoles);
					} catch (\Throwable $e) {
						dd($className);
					}

					if (!$roles) return;

					foreach ($roles as $role => $name) {
						$name = (!empty($aliasName)) ? $aliasName . ': ' . $name : $className . ': ' . $name;
						$code = $className . '.' . $role;

						$this->roles[] = [
							'code' => $code,
							'name' => $name
						];
					}
				});

			return $this;
		}

		/**
		 * @param $path
		 * @param $namespace
		 * @return Collection
		 */
		protected function getReflectionList($path, $namespace) {
			$list = collect(scandir($path))
				->filter(function ($item) {
					$info = pathInfo($item);

					return ($info['extension'] ?? false) == 'php';
				})
				->map(function ($item) use ($namespace) {
					$info = pathInfo($item);

					$fileNameSpace = $namespace . $info['filename'];

					return new \ReflectionClass($fileNameSpace);
				});

			return $list;
		}

		/**
		 * @return $this
		 */
		protected function separateRoles() {
			$this->roles = collect($this->roles)
				->groupBy(function ($item) {
					if (!$this->existsRoles->has($item['code'])) return 'create';

					return $this->isNoChange($item) ? 'no_change' : 'update';
				})
				->toArray();

			return $this;
		}

		/**
		 * @return $this
		 */
		protected function insertRoles() {
			$createRoles = collect($this->roles['create'] ?? [])
				->map(function ($item) {
					$item['created_at'] = $item['updated_at'] = $this->now;

					return $item;
				})
				->toArray();

			\DB::table('user_roles')->insert($createRoles);

			return $this;
		}

		/**
		 * @return $this
		 */
		protected function updateRoles() {
			collect($this->roles['update'] ?? [])
				->map(function ($item) {
					$item['updated_at'] = $this->now;

					\DB::table('user_roles')
						->where('code', $item['code'])
						->update($item);
				});

			return $this;
		}

		/**
		 * @param array $item
		 * @return bool
		 */
		protected function isNoChange($item) {
			return $this->existsRoles->get($item['code'])->name == $item['name'];
		}
	}
