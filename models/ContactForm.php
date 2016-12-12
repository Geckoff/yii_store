<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email']
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject('Message from Random Store: '.$this->subject)
                ->setHtmlBody('<h2>Message from:</h2><br>'.$this->name.' - '.$this->email.'<br><h2>Subject:</h2><br>'.$this->subject.'<br><h2>Message:</h2><br>'.$this->body)
                ->send();
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom(['no-reply@hetsevich.com' => 'Random Store'])
                ->setSubject('Your massage is recieved')
                ->setHtmlBody($this->name.'!<br>Thank you for contacting Random Store. Our assistant will contact you soon.')
                ->send();

            return true;
        }
        return false;
    }
}
