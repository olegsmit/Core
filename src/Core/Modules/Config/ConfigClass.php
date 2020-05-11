<?php
/**
 * Copyright © MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Alexey Portnov, 2 2020
 */

namespace MikoPBX\Core\Modules\Config;

use MikoPBX\Core\System\MikoPBXConfig;
use Phalcon\Di;

abstract class ConfigClass implements SystemConfigInterface, AsteriskConfigInterface
{
    // Директория конфигурационных файлов Asterisk;
    protected $astConfDir;

    // Описание класса (имя конф. файла).
    protected $description;

    /**
     * @var mixed|\Phalcon\Di\DiInterface|null
     */
    protected $di;

    /**
     * @var \MikoPBX\Core\System\MikoPBXConfig
     */
    protected $mikoPBXConfig;

    /**
     * @var bool
     */
    protected $booting;


    /**
     * ConfigClass constructor.
     *
     */
    public function __construct()
    {
        $this->di            = Di::getDefault();
        $config              = $this->di->getShared('config');
        $this->astConfDir    = $config->path('asterisk.confDir');
        $this->modulesDir    = $config->path('core.modulesDir');
        $this->booting       = $this->di->getRegistry()->booting;
        $this->mikoPBXConfig = new MikoPBXConfig();
        $this->getSettings();
    }

    public function getSettings(): void
    {
    }

    public function generateConfig($general_settings): void
    {
        // Генерация конфигурационных файлов.
        $this->echoGenerateConfig();
        $this->generateConfigProtected($general_settings);
        $this->echoDone();
    }

    // Настройки для текущего класса.
    // Метод вызывается при создании объекта.

    /**
     * Вывод сообщения о генерации конфига.
     */
    protected function echoGenerateConfig(): void
    {
        if ($this->booting === true && $this->description != null) {
            echo "   |- generate config {$this->description}... ";
        }
    }

    /**
     * Генерация конфигурационного файла asterisk.
     * $general_settings - массив глобальных настроек.
     *
     * @param $general_settings
     */
    protected function generateConfigProtected($general_settings)
    {
    }

    /**
     * Вывод сообщения об окончании генерации.
     */
    protected function echoDone(): void
    {
        if ($this->booting === true && $this->description != null) {
            echo "\033[32;1mdone\033[0m \n";
        }
    }

    // Получаем строки include для секции internal.

    public function getIncludeInternal(): string
    {
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    // Получаем строки include для секции internal-transfer.
    public function getIncludeInternalTransfer() :string
    {
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    // Генератор extension для контекста internal.
    public function extensionGenInternal(): string
    {
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    // Генератор extension для контекста internal.
    public function extensionGenInternalTransfer(): string
    {
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    /**
     * Опираясь на ID учетной записи возвращает имя технологии SIP / IAX2.
     *
     * @param string $id
     *
     * @return string
     */
    public function getTechByID($id): string
    {
        unset($id);
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    // Генератор extension для контекста peers.
    public function extensionGenPeerContexts()
    {
        // Генерация внутреннего номерного плана.
        $result = '';

        return $result;
    }

    // Генератор extensions, дополнительные контексты.
    public function extensionGenContexts(): string
    {
        $result = '';

        return $result;
    }

    // Генератор хинтов для контекста internal-hints
    public function extensionGenHints(): string
    {
        // Генерация хинтов.
        $result = '';

        return $result;
    }

    // Секция global для extensions.conf.
    public function extensionGlobals(): string
    {
        // Генерация хинтов.
        $result = '';

        return $result;
    }

    // Секция featuremap для features.conf
    public function getFeatureMap(): string
    {
        // Возвращает старкоды.
        return '';
    }

    /**
     * Генерация контекста для публичных звонков.
     *
     * @param $conf
     *
     * @return void
     */
    public function generatePublicContext(&$conf) :void
    {
    }

    /**
     * Проверка работы сервисов.
     */
    public function test(): array
    {
        return ['result' => true];
    }

    /**
     * Генерация конфига, рестарт работы модуля.
     * Метод вызывается после рестарта NATS сервера.
     */
    public function onNatsReload(): void
    {
    }

    /**
     * Перезапуск сервисов модуля.
     *
     * @return void
     */
    public function reloadServices(): void
    {
    }

    /**
     * Будет вызван после старта asterisk.
     */
    public function onAfterPbxStarted(): void
    {
    }

    /**
     * Добавление задач в crond.
     *
     * @param $tasks
     */
    public function createCronTasks(&$tasks): void
    {
    }

    /**
     * Модули: Выполнение к-либо действия.
     *
     * @param $req_data
     *
     * @return array
     */
    public function customAction($req_data): array
    {
        return [
            'result' => 'ERROR',
            'data'   => $req_data,
        ];
    }

    /**
     * Генератор сеции пиров для sip.conf
     *
     * @return string
     */
    public function generatePeers($param): string
    {
        unset($param);

        return '';
    }

    /**
     * Генератор сеции пиров для sip.conf
     *
     * @return string
     */
    public function generatePeersPj($param): string
    {
        unset($param);

        return '';
    }

    /**
     * Генератор сеции пиров для manager.conf
     *
     * @return string
     */
    public function generateManager($param): string
    {
        unset($param);

        return '';
    }

    /**
     * Дополнительные параметры для
     *
     * @param $peer
     *
     * @return string
     */
    public function generatePeerPjAdditionalOptions($peer): string
    {
        return '';
    }

    /**
     * Кастомизация исходящего контекста для конкретного маршрута.
     *
     * @param $peer
     *
     * @return string
     */
    public function generateOutRoutContext($rout): string
    {
        return '';
    }

    /**
     * Кастомизация исходящего контекста для конкретного маршрута.
     *
     * @param $peer
     *
     * @return string
     */
    public function generateOutRoutAfterDialContext($rout): string
    {
        return '';
    }

    /**
     * Кастомизация входящего контекста для конкретного маршрута.
     *
     * @param $id
     *
     * @return string
     */
    public function generateIncomingRoutAfterDialContext($id): string
    {
        return '';
    }

    /**
     * Кастомизация входящего контекста для конкретного маршрута.
     *
     * @param $peer
     *
     * @return string
     */
    public function generateIncomingRoutBeforeDial($rout_number): string
    {
        return '';
    }

    /**
     * Обработчик события изменения данных в базе настроек mikopbx.db.
     *
     * @param $data
     */
    public function modelsEventChangeData($data): void
    {
    }

    /**
     * Обработчик события изменения данных в базе настроек mikopbx.db.
     *
     * @param $modified_tables
     */
    public function modelsEventNeedReload($modified_tables): void
    {
    }

    /**
     * Returns array of additional routes for PBXCoreREST interface from module
     *
     * @return array
     */
    public function getPBXCoreRESTAdditionalRoutes(): array
    {
        return [];
    }

}