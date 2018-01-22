<?php

use yii\db\Migration;

/**
 * Создаем таблицу build
 * См. официальную [документацию по миграциям](https://github.com/yiisoft/yii2/blob/master/docs/guide-ru/db-migrations.md)
 */
class m180116_184646_build extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%build}}', [
            'id' => $this->primaryKey(),

            'user_id' => $this->integer()->notNull(),

            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'buildname' => $this->string(100)->notNull()->unique(),

            'description' => $this->text(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        // creates index for column `user_id`
        $this->createIndex(
            'idx-build-user_id',
            'build',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-build-user_id',
            'build',
            'user_id',
            'user',
            'id',
            'RESTRICT'
        );
    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-build-user_id',
            'build'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-build-user_id',
            'build'
        );

        $this->dropTable('{{%build}}');
    }
}
