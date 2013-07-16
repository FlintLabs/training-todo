<?php

$schema = new \Doctrine\DBAL\Schema\Schema();

$task = $schema->createTable('task');
$task->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$task->addColumn('title', 'string', array('length' => 32));
$task->addColumn('created_at', 'date');
$task->addColumn('due_at', 'date');
$task->setPrimaryKey(array('id'));

$tag = $schema->createTable('tag');
$tag->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
$tag->addColumn('title', 'string', array('length' => 32));
$tag->setPrimaryKey(array('id'));

return $schema;
