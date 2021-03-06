<?php

namespace DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use DB\Group as ChildGroup;
use DB\GroupQuery as ChildGroupQuery;
use DB\Mailing as ChildMailing;
use DB\MailingQuery as ChildMailingQuery;
use DB\Victim as ChildVictim;
use DB\VictimQuery as ChildVictimQuery;
use DB\WebConversionQuery as ChildWebConversionQuery;
use DB\Map\WebConversionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'WebConversions' table.
 *
 *
 *
 * @package    propel.generator.DB.Base
 */
abstract class WebConversion implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\DB\\Map\\WebConversionTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the mailing_id field.
     *
     * @var        int
     */
    protected $mailing_id;

    /**
     * The value for the group_id field.
     *
     * @var        int
     */
    protected $group_id;

    /**
     * The value for the timestamp field.
     *
     * @var        DateTime
     */
    protected $timestamp;

    /**
     * The value for the victim_id field.
     *
     * @var        int
     */
    protected $victim_id;

    /**
     * The value for the unknown_id field.
     *
     * @var        string
     */
    protected $unknown_id;

    /**
     * The value for the conversion_name field.
     *
     * @var        string
     */
    protected $conversion_name;

    /**
     * The value for the form_data field.
     *
     * @var        string
     */
    protected $form_data;

    /**
     * The value for the unique_id field.
     *
     * @var        string
     */
    protected $unique_id;

    /**
     * @var        ChildMailing
     */
    protected $aMailing;

    /**
     * @var        ChildVictim
     */
    protected $aVictim;

    /**
     * @var        ChildGroup
     */
    protected $aGroup;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of DB\Base\WebConversion object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>WebConversion</code> instance.  If
     * <code>obj</code> is an instance of <code>WebConversion</code>, delegates to
     * <code>equals(WebConversion)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|WebConversion The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [mailing_id] column value.
     *
     * @return int
     */
    public function getMailingId()
    {
        return $this->mailing_id;
    }

    /**
     * Get the [group_id] column value.
     *
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Get the [optionally formatted] temporal [timestamp] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimestamp($format = NULL)
    {
        if ($format === null) {
            return $this->timestamp;
        } else {
            return $this->timestamp instanceof \DateTimeInterface ? $this->timestamp->format($format) : null;
        }
    }

    /**
     * Get the [victim_id] column value.
     *
     * @return int
     */
    public function getVictimId()
    {
        return $this->victim_id;
    }

    /**
     * Get the [unknown_id] column value.
     *
     * @return string
     */
    public function getUnknownId()
    {
        return $this->unknown_id;
    }

    /**
     * Get the [conversion_name] column value.
     *
     * @return string
     */
    public function getConversionName()
    {
        return $this->conversion_name;
    }

    /**
     * Get the [form_data] column value.
     *
     * @return string
     */
    public function getFormData()
    {
        return $this->form_data;
    }

    /**
     * Get the [unique_id] column value.
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [mailing_id] column.
     *
     * @param int $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setMailingId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->mailing_id !== $v) {
            $this->mailing_id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_MAILING_ID] = true;
        }

        if ($this->aMailing !== null && $this->aMailing->getId() !== $v) {
            $this->aMailing = null;
        }

        return $this;
    } // setMailingId()

    /**
     * Set the value of [group_id] column.
     *
     * @param int $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setGroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->group_id !== $v) {
            $this->group_id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_GROUP_ID] = true;
        }

        if ($this->aGroup !== null && $this->aGroup->getId() !== $v) {
            $this->aGroup = null;
        }

        return $this;
    } // setGroupId()

    /**
     * Sets the value of [timestamp] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setTimestamp($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timestamp !== null || $dt !== null) {
            if ($this->timestamp === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->timestamp->format("Y-m-d H:i:s.u")) {
                $this->timestamp = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WebConversionTableMap::COL_TIMESTAMP] = true;
            }
        } // if either are not null

        return $this;
    } // setTimestamp()

    /**
     * Set the value of [victim_id] column.
     *
     * @param int $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setVictimId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->victim_id !== $v) {
            $this->victim_id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_VICTIM_ID] = true;
        }

        if ($this->aVictim !== null && $this->aVictim->getId() !== $v) {
            $this->aVictim = null;
        }

        return $this;
    } // setVictimId()

    /**
     * Set the value of [unknown_id] column.
     *
     * @param string $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setUnknownId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unknown_id !== $v) {
            $this->unknown_id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_UNKNOWN_ID] = true;
        }

        return $this;
    } // setUnknownId()

    /**
     * Set the value of [conversion_name] column.
     *
     * @param string $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setConversionName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->conversion_name !== $v) {
            $this->conversion_name = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_CONVERSION_NAME] = true;
        }

        return $this;
    } // setConversionName()

    /**
     * Set the value of [form_data] column.
     *
     * @param string $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setFormData($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->form_data !== $v) {
            $this->form_data = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_FORM_DATA] = true;
        }

        return $this;
    } // setFormData()

    /**
     * Set the value of [unique_id] column.
     *
     * @param string $v new value
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     */
    public function setUniqueId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unique_id !== $v) {
            $this->unique_id = $v;
            $this->modifiedColumns[WebConversionTableMap::COL_UNIQUE_ID] = true;
        }

        return $this;
    } // setUniqueId()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WebConversionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WebConversionTableMap::translateFieldName('MailingId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->mailing_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WebConversionTableMap::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->group_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : WebConversionTableMap::translateFieldName('Timestamp', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->timestamp = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : WebConversionTableMap::translateFieldName('VictimId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->victim_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : WebConversionTableMap::translateFieldName('UnknownId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unknown_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : WebConversionTableMap::translateFieldName('ConversionName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->conversion_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : WebConversionTableMap::translateFieldName('FormData', TableMap::TYPE_PHPNAME, $indexType)];
            $this->form_data = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : WebConversionTableMap::translateFieldName('UniqueId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unique_id = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = WebConversionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\DB\\WebConversion'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aMailing !== null && $this->mailing_id !== $this->aMailing->getId()) {
            $this->aMailing = null;
        }
        if ($this->aGroup !== null && $this->group_id !== $this->aGroup->getId()) {
            $this->aGroup = null;
        }
        if ($this->aVictim !== null && $this->victim_id !== $this->aVictim->getId()) {
            $this->aVictim = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WebConversionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWebConversionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMailing = null;
            $this->aVictim = null;
            $this->aGroup = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see WebConversion::setDeleted()
     * @see WebConversion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildWebConversionQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                WebConversionTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aMailing !== null) {
                if ($this->aMailing->isModified() || $this->aMailing->isNew()) {
                    $affectedRows += $this->aMailing->save($con);
                }
                $this->setMailing($this->aMailing);
            }

            if ($this->aVictim !== null) {
                if ($this->aVictim->isModified() || $this->aVictim->isNew()) {
                    $affectedRows += $this->aVictim->save($con);
                }
                $this->setVictim($this->aVictim);
            }

            if ($this->aGroup !== null) {
                if ($this->aGroup->isModified() || $this->aGroup->isNew()) {
                    $affectedRows += $this->aGroup->save($con);
                }
                $this->setGroup($this->aGroup);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[WebConversionTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WebConversionTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WebConversionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_MAILING_ID)) {
            $modifiedColumns[':p' . $index++]  = 'mailing_id';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_GROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'group_id';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_TIMESTAMP)) {
            $modifiedColumns[':p' . $index++]  = 'timestamp';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_VICTIM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'victim_id';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_UNKNOWN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'unknown_id';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_CONVERSION_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'conversion_name';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_FORM_DATA)) {
            $modifiedColumns[':p' . $index++]  = 'form_data';
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_UNIQUE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'unique_id';
        }

        $sql = sprintf(
            'INSERT INTO WebConversions (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'mailing_id':
                        $stmt->bindValue($identifier, $this->mailing_id, PDO::PARAM_INT);
                        break;
                    case 'group_id':
                        $stmt->bindValue($identifier, $this->group_id, PDO::PARAM_INT);
                        break;
                    case 'timestamp':
                        $stmt->bindValue($identifier, $this->timestamp ? $this->timestamp->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'victim_id':
                        $stmt->bindValue($identifier, $this->victim_id, PDO::PARAM_INT);
                        break;
                    case 'unknown_id':
                        $stmt->bindValue($identifier, $this->unknown_id, PDO::PARAM_STR);
                        break;
                    case 'conversion_name':
                        $stmt->bindValue($identifier, $this->conversion_name, PDO::PARAM_STR);
                        break;
                    case 'form_data':
                        $stmt->bindValue($identifier, $this->form_data, PDO::PARAM_STR);
                        break;
                    case 'unique_id':
                        $stmt->bindValue($identifier, $this->unique_id, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = WebConversionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getMailingId();
                break;
            case 2:
                return $this->getGroupId();
                break;
            case 3:
                return $this->getTimestamp();
                break;
            case 4:
                return $this->getVictimId();
                break;
            case 5:
                return $this->getUnknownId();
                break;
            case 6:
                return $this->getConversionName();
                break;
            case 7:
                return $this->getFormData();
                break;
            case 8:
                return $this->getUniqueId();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['WebConversion'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['WebConversion'][$this->hashCode()] = true;
        $keys = WebConversionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getMailingId(),
            $keys[2] => $this->getGroupId(),
            $keys[3] => $this->getTimestamp(),
            $keys[4] => $this->getVictimId(),
            $keys[5] => $this->getUnknownId(),
            $keys[6] => $this->getConversionName(),
            $keys[7] => $this->getFormData(),
            $keys[8] => $this->getUniqueId(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMailing) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mailing';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Mailings';
                        break;
                    default:
                        $key = 'Mailing';
                }

                $result[$key] = $this->aMailing->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aVictim) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'victim';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Victims';
                        break;
                    default:
                        $key = 'Victim';
                }

                $result[$key] = $this->aVictim->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aGroup) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'group';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'Groups';
                        break;
                    default:
                        $key = 'Group';
                }

                $result[$key] = $this->aGroup->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\DB\WebConversion
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = WebConversionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\DB\WebConversion
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setMailingId($value);
                break;
            case 2:
                $this->setGroupId($value);
                break;
            case 3:
                $this->setTimestamp($value);
                break;
            case 4:
                $this->setVictimId($value);
                break;
            case 5:
                $this->setUnknownId($value);
                break;
            case 6:
                $this->setConversionName($value);
                break;
            case 7:
                $this->setFormData($value);
                break;
            case 8:
                $this->setUniqueId($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = WebConversionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setMailingId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setGroupId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTimestamp($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setVictimId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUnknownId($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setConversionName($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setFormData($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUniqueId($arr[$keys[8]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\DB\WebConversion The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(WebConversionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WebConversionTableMap::COL_ID)) {
            $criteria->add(WebConversionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_MAILING_ID)) {
            $criteria->add(WebConversionTableMap::COL_MAILING_ID, $this->mailing_id);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_GROUP_ID)) {
            $criteria->add(WebConversionTableMap::COL_GROUP_ID, $this->group_id);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_TIMESTAMP)) {
            $criteria->add(WebConversionTableMap::COL_TIMESTAMP, $this->timestamp);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_VICTIM_ID)) {
            $criteria->add(WebConversionTableMap::COL_VICTIM_ID, $this->victim_id);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_UNKNOWN_ID)) {
            $criteria->add(WebConversionTableMap::COL_UNKNOWN_ID, $this->unknown_id);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_CONVERSION_NAME)) {
            $criteria->add(WebConversionTableMap::COL_CONVERSION_NAME, $this->conversion_name);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_FORM_DATA)) {
            $criteria->add(WebConversionTableMap::COL_FORM_DATA, $this->form_data);
        }
        if ($this->isColumnModified(WebConversionTableMap::COL_UNIQUE_ID)) {
            $criteria->add(WebConversionTableMap::COL_UNIQUE_ID, $this->unique_id);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildWebConversionQuery::create();
        $criteria->add(WebConversionTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \DB\WebConversion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMailingId($this->getMailingId());
        $copyObj->setGroupId($this->getGroupId());
        $copyObj->setTimestamp($this->getTimestamp());
        $copyObj->setVictimId($this->getVictimId());
        $copyObj->setUnknownId($this->getUnknownId());
        $copyObj->setConversionName($this->getConversionName());
        $copyObj->setFormData($this->getFormData());
        $copyObj->setUniqueId($this->getUniqueId());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \DB\WebConversion Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildMailing object.
     *
     * @param  ChildMailing $v
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMailing(ChildMailing $v = null)
    {
        if ($v === null) {
            $this->setMailingId(NULL);
        } else {
            $this->setMailingId($v->getId());
        }

        $this->aMailing = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMailing object, it will not be re-added.
        if ($v !== null) {
            $v->addWebConversion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMailing object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMailing The associated ChildMailing object.
     * @throws PropelException
     */
    public function getMailing(ConnectionInterface $con = null)
    {
        if ($this->aMailing === null && ($this->mailing_id !== null)) {
            $this->aMailing = ChildMailingQuery::create()->findPk($this->mailing_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMailing->addWebConversions($this);
             */
        }

        return $this->aMailing;
    }

    /**
     * Declares an association between this object and a ChildVictim object.
     *
     * @param  ChildVictim $v
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setVictim(ChildVictim $v = null)
    {
        if ($v === null) {
            $this->setVictimId(NULL);
        } else {
            $this->setVictimId($v->getId());
        }

        $this->aVictim = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildVictim object, it will not be re-added.
        if ($v !== null) {
            $v->addWebConversion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildVictim object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildVictim The associated ChildVictim object.
     * @throws PropelException
     */
    public function getVictim(ConnectionInterface $con = null)
    {
        if ($this->aVictim === null && ($this->victim_id !== null)) {
            $this->aVictim = ChildVictimQuery::create()->findPk($this->victim_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aVictim->addWebConversions($this);
             */
        }

        return $this->aVictim;
    }

    /**
     * Declares an association between this object and a ChildGroup object.
     *
     * @param  ChildGroup $v
     * @return $this|\DB\WebConversion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setGroup(ChildGroup $v = null)
    {
        if ($v === null) {
            $this->setGroupId(NULL);
        } else {
            $this->setGroupId($v->getId());
        }

        $this->aGroup = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildGroup object, it will not be re-added.
        if ($v !== null) {
            $v->addWebConversion($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildGroup object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildGroup The associated ChildGroup object.
     * @throws PropelException
     */
    public function getGroup(ConnectionInterface $con = null)
    {
        if ($this->aGroup === null && ($this->group_id !== null)) {
            $this->aGroup = ChildGroupQuery::create()->findPk($this->group_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aGroup->addWebConversions($this);
             */
        }

        return $this->aGroup;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aMailing) {
            $this->aMailing->removeWebConversion($this);
        }
        if (null !== $this->aVictim) {
            $this->aVictim->removeWebConversion($this);
        }
        if (null !== $this->aGroup) {
            $this->aGroup->removeWebConversion($this);
        }
        $this->id = null;
        $this->mailing_id = null;
        $this->group_id = null;
        $this->timestamp = null;
        $this->victim_id = null;
        $this->unknown_id = null;
        $this->conversion_name = null;
        $this->form_data = null;
        $this->unique_id = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aMailing = null;
        $this->aVictim = null;
        $this->aGroup = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WebConversionTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
