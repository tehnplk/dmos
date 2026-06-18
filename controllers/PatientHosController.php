<?php

namespace app\controllers;

use app\models\PatientHos;
use app\models\PatientHosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\MyRole;
use app\models\PatientViewLog;
use Yii;
use yii\db\Query;

/**
 * PatientHosController implements the CRUD actions for PatientHos model.
 */
class PatientHosController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => \yii\filters\AccessControl::className(),
                        'only' => ['index', 'view', 'create', 'update', 'delete', 'accept', 'reject', 'export'],
                        'rules' => [
                            [
                                'actions' => ['export'],
                                'allow' => \app\components\MyRole::can_pro(),
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['view', 'index',],
                                'allow' => '*',
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['create', 'delete', 'update'],
                                'allow' => \app\components\MyRole::can_report() || \app\components\MyRole::can_all_update(),
                                'roles' => ['@'],
                            ],
                            [
                                'actions' => ['accept', 'reject'],
                                'allow' => \app\components\MyRole::can_accept(),
                                'roles' => ['@'],
                            ],
                        ],
                    ],
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    /**
     * Lists all PatientHos models.
     *
     * @return string
     */
    public function actionExport() {
        $model = new \app\models\DateRangeForm();
        if (!$this->request->isPost) {

            return $this->render('export', [
                        'model' => $model
            ]);
        }

        $model->load(Yii::$app->request->post());
        $startDate = $model->startDate;
        $endDate = $model->endDate;

        $sql = "SELECT 
                    hoscode, hosname, hn, cid, pname, fname, lname, gender, birth_date, 
                    age_y, age_m, occupat, pic, prov, amp, tmb, moo, street, place, addr, 
                    tel, family, addr_note, date_sick, date_visit, symptom, dx, date_dx, 
                    doctor, REPLACE(REPLACE(lab, '\r\n', ' '), '\n', ' ') AS lab, discharge_type, date_discharge, note, reporter, 
                    reporter_position, reporter_tel, dc, created_at, created_by, 
                    updated_at, updated_by, accepted_hoscode, accepted_hosname, 
                    accepted_at
                FROM patient_hos 
                WHERE deleted_at IS NULL and date_visit between :startDate and :endDate";
        //return $sql;
        $data = Yii::$app->db->createCommand($sql, [
                    ':startDate' => $startDate,
                    ':endDate' => $endDate
                ])->queryAll();

        $fileName = 'export_patient_hos_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = Yii::getAlias('@runtime/' . $fileName);

        $file = fopen($filePath, 'w');

        $header = [
            'Hoscode', 'Hosname', 'HN', 'CID', 'PName', 'FName', 'LName', 'Gender', 'Birth Date',
            'Age (Years)', 'Age (Months)', 'Occupation', 'Picture', 'Province', 'Amphur', 'Tambon',
            'Moo', 'Street', 'Place', 'Address', 'Telephone', 'Family', 'Address Note', 'Date Sick',
            'Date Visit', 'Symptom', 'Diagnosis', 'Date Diagnosis', 'Doctor', 'Lab', 'Discharge Type',
            'Date Discharge', 'Note', 'Reporter', 'Reporter Position', 'Reporter Tel', 'DC',
            'Created At', 'Created By', 'Updated At', 'Updated By', 'Accepted Hoscode', 'Accepted Hosname',
            'Accepted At'
        ];
        fputcsv($file, $header);

        foreach ($data as $row) {
            fputcsv($file, [
                $row['hoscode'],
                $row['hosname'],
                $row['hn'],
                $row['cid'],
                $row['pname'],
                $row['fname'],
                $row['lname'],
                $row['gender'],
                $row['birth_date'],
                $row['age_y'],
                $row['age_m'],
                $row['occupat'],
                $row['pic'],
                $row['prov'],
                $row['amp'],
                $row['tmb'],
                $row['moo'],
                $row['street'],
                $row['place'],
                $row['addr'],
                $row['tel'],
                $row['family'],
                $row['addr_note'],
                $row['date_sick'],
                $row['date_visit'],
                $row['symptom'],
                $row['dx'],
                $row['date_dx'],
                $row['doctor'],
                $row['lab'],
                $row['discharge_type'],
                $row['date_discharge'],
                $row['note'],
                $row['reporter'],
                $row['reporter_position'],
                $row['reporter_tel'],
                $row['dc'],
                $row['created_at'],
                $row['created_by'],
                $row['updated_at'],
                $row['updated_by'],
                $row['accepted_hoscode'],
                $row['accepted_hosname'],
                $row['accepted_at']
            ]);
        }

        fclose($file);

        return Yii::$app->response->sendFile($filePath)->on(\yii\web\Response::EVENT_AFTER_SEND, function ($event) {
                    unlink($event->data);
                }, $filePath);
    }

// end export

    public function actionIndex($new = null) {
        $searchModel = new PatientHosSearch();
        if ($new == 1) {
            $searchModel->accepted_hoscode = 'ยังไม่รับ';
        }
        if ($new == 2) {
            $searchModel->hoscode = \Yii::$app->user->identity->hoscode;
        }
        if ($new == 3) {
            $searchModel->accepted_hoscode = \Yii::$app->user->identity->hoscode;
        }
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PatientHos model.
     * @param int $id #
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $this->layout = 'no-navbar';
        $model = new PatientViewLog();
        $model->patient_id = $id;
        $model->view_date = date('Y-m-d H:i:s');
        $model->viewer_user_id = \Yii::$app->user->identity->id;
        $model->viewer_user_hoscode = \Yii::$app->user->identity->hoscode;
        $model->viewer_user_hosname = \Yii::$app->user->identity->hosname;
        $model->ip_viewer = \Yii::$app->request->userIP;
        $model->save(false);
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PatientHos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new PatientHos();
        $model->prov = 'พิษณุโลก';
        $model->hoscode = \Yii::$app->user->identity->hoscode;
        $model->hosname = \Yii::$app->user->identity->hosname;
        $model->accepted_hoscode = 'ยังไม่รับ';

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PatientHos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id #
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $this->layout = 'no-navbar';
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', "แก้ไขสำเร็จ !");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionAccept($id) {
        //$id = $this->request->post('id');
        $model = $this->findModel($id);
        $model->load($this->request->post());
        $model->accepted_at = date('Y-m-d H:i:s');
        $model->accepted_hoscode = \Yii::$app->user->identity->hoscode;
        $model->accepted_hosname = \Yii::$app->user->identity->hosname;

        $model->accepted_reject_at = null;
        $model->accepted_reject_note = null;
        $model->save(false);
        \Yii::$app->session->setFlash('success', "รับเคสสำเร็จ !");
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionReject() {
        $id = $this->request->post('id');
        $model = $this->findModel($id);
        $model->load($this->request->post());
        $model->accepted_at = null;
        $model->accepted_hoscode = 'ยังไม่รับ';
        $model->accepted_hosname = null;
        $model->accepted_reject_at = date('Y-m-d H:i:s');
        $model->accepted_reject_note = \Yii::$app->user->identity->hoscode . '-' . $model->accepted_reject_note;
        $model->save(false);
        return $this->redirect(['view', 'id' => $id]);
        //return $this->redirect(['index', 'new' => 3]);
    }

    /**
     * Deletes an existing PatientHos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id #
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->layout = 'no-navbar';
        $model = $this->findModel($id);
        $model->load($this->request->post());
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->deleted_by = \Yii::$app->user->identity->id;
        $model->save(false);
        return $this->render('delete-success');
        //return $this->redirect(['del', 'id' => $id]);
        //return $this->redirect(['index', 'new' => 2]);
    }

    /**
     * Finds the PatientHos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id #
     * @return PatientHos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PatientHos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
