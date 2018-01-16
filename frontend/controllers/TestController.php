<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use frontend\models\UploadFileForm;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\filters\AccessControl;
use yii\db\Exception;

class TestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new UploadFileForm();
        $uploaded = false;

        if (Yii::$app->request->post()) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                // Путь и имя для временного файла
                // $model->file не используем, т.к. могут загрузить несколько разных файлов с одинаковым имененм
                $filename = md5(time());
                $path_filename = Yii::$app->runtimePath . '/test_' . $filename;

                // Сохраняем
                $model->file->saveAs($path_filename);

                $uploaded = true;
            }
        }

        return $this->render('index', ['model' => $model, 'uploaded' => $uploaded, 'filename' => $filename]);
    }

    public function actionPay()
    {
        $path_filename = Yii::$app->runtimePath . '/test_' . $_POST['filename'];

        // Есть файл и его разсер больше 0
        if (!file_exists($path_filename) || !($path_filename) > 0)
            return $this->redirect(['test/index']);


        // Открываем файл с помощью фэктори с нужным загрузчиком
        $spreadsheet = IOFactory::load($path_filename);

        $results = [];

        // Извлекаем данные из не пустых листов
        for ($i = 0; $i < $spreadsheet->getSheetCount(); $i++) {
            $activesheet = $spreadsheet->setActiveSheetIndex($i);

            $maxCol = $activesheet->getHighestColumn();
            $maxRow = $activesheet->getHighestRow();

            // Не заполненные листы или ячейки - игнорируем их
            if ($maxCol == 'A' && $maxRow == 1)
                continue;

            $sheetData = $activesheet->toArray(null, true, true, true);

            // Смотрим все строки на листе на предмет наличия в них нужных данных
            foreach ($sheetData as $data) {
                // На листе должно быть не менее 3-х столбцов
                if (count($data) != 3 || ($data['A'] == '') || (!is_numeric($data['B'])) || ($data['B'] == '') || ($data['C'] == ''))
                    continue;

                // Нашли нужную запись
                $results[] = $this->addMailRecord($data['A'], $data['B'], $data['C']);
            }
        }

        unlink($path_filename);

        return $this->render('pay', ['results' => $results]);
    }

    protected function addMailRecord($email, $sum, $cur)
    {
        $result = "$email, $sum, $cur";

        // Фиксируем в БД
        try {
            Yii::$app->db->createCommand('insert into currency_operation (sum, currency, currency_from) values (:sum, :currency, :currency_from)')
                ->bindValue('sum', $sum)
                ->bindValue(':currency', $cur)
                ->bindValue(':currency_from', $email)
                ->execute();
        } catch (Exception $e) {
        }

        // Указан адрес - отсылаем письмо
        if (strpos($email, '@') !== false) {

            if (Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom('info@upload_operation.com')
                ->setSubject('Прошла оплата!')
                ->setTextBody("Прошла оплата для: $email, сумма: $sum, валюта: $cur")
                ->setHtmlBody('<b>Прошла оплата для: $email, сумма: $sum, валюта: $cur</b>')
                ->send())
                $result .= ' - письмо отправлено!';
            else
                $result .= ' - ошибка при отправке письма';
        } else
            $result .= ' - нет адреса';

        return $result;
    }

}
