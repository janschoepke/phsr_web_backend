<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\WebConversion as ChildWebConversion;
use DB\WebConversionQuery as ChildWebConversionQuery;
use DB\Map\WebConversionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'WebConversions' table.
 *
 *
 *
 * @method     ChildWebConversionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildWebConversionQuery orderByMailingId($order = Criteria::ASC) Order by the mailing_id column
 * @method     ChildWebConversionQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     ChildWebConversionQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildWebConversionQuery orderByVictimId($order = Criteria::ASC) Order by the victim_id column
 * @method     ChildWebConversionQuery orderByUnknownId($order = Criteria::ASC) Order by the unknown_id column
 * @method     ChildWebConversionQuery orderByConversionName($order = Criteria::ASC) Order by the conversion_name column
 * @method     ChildWebConversionQuery orderByFormData($order = Criteria::ASC) Order by the form_data column
 * @method     ChildWebConversionQuery orderByUniqueId($order = Criteria::ASC) Order by the unique_id column
 *
 * @method     ChildWebConversionQuery groupById() Group by the id column
 * @method     ChildWebConversionQuery groupByMailingId() Group by the mailing_id column
 * @method     ChildWebConversionQuery groupByGroupId() Group by the group_id column
 * @method     ChildWebConversionQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildWebConversionQuery groupByVictimId() Group by the victim_id column
 * @method     ChildWebConversionQuery groupByUnknownId() Group by the unknown_id column
 * @method     ChildWebConversionQuery groupByConversionName() Group by the conversion_name column
 * @method     ChildWebConversionQuery groupByFormData() Group by the form_data column
 * @method     ChildWebConversionQuery groupByUniqueId() Group by the unique_id column
 *
 * @method     ChildWebConversionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWebConversionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWebConversionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWebConversionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWebConversionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWebConversionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWebConversionQuery leftJoinMailing($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mailing relation
 * @method     ChildWebConversionQuery rightJoinMailing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mailing relation
 * @method     ChildWebConversionQuery innerJoinMailing($relationAlias = null) Adds a INNER JOIN clause to the query using the Mailing relation
 *
 * @method     ChildWebConversionQuery joinWithMailing($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Mailing relation
 *
 * @method     ChildWebConversionQuery leftJoinWithMailing() Adds a LEFT JOIN clause and with to the query using the Mailing relation
 * @method     ChildWebConversionQuery rightJoinWithMailing() Adds a RIGHT JOIN clause and with to the query using the Mailing relation
 * @method     ChildWebConversionQuery innerJoinWithMailing() Adds a INNER JOIN clause and with to the query using the Mailing relation
 *
 * @method     ChildWebConversionQuery leftJoinVictim($relationAlias = null) Adds a LEFT JOIN clause to the query using the Victim relation
 * @method     ChildWebConversionQuery rightJoinVictim($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Victim relation
 * @method     ChildWebConversionQuery innerJoinVictim($relationAlias = null) Adds a INNER JOIN clause to the query using the Victim relation
 *
 * @method     ChildWebConversionQuery joinWithVictim($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Victim relation
 *
 * @method     ChildWebConversionQuery leftJoinWithVictim() Adds a LEFT JOIN clause and with to the query using the Victim relation
 * @method     ChildWebConversionQuery rightJoinWithVictim() Adds a RIGHT JOIN clause and with to the query using the Victim relation
 * @method     ChildWebConversionQuery innerJoinWithVictim() Adds a INNER JOIN clause and with to the query using the Victim relation
 *
 * @method     ChildWebConversionQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     ChildWebConversionQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     ChildWebConversionQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     ChildWebConversionQuery joinWithGroup($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Group relation
 *
 * @method     ChildWebConversionQuery leftJoinWithGroup() Adds a LEFT JOIN clause and with to the query using the Group relation
 * @method     ChildWebConversionQuery rightJoinWithGroup() Adds a RIGHT JOIN clause and with to the query using the Group relation
 * @method     ChildWebConversionQuery innerJoinWithGroup() Adds a INNER JOIN clause and with to the query using the Group relation
 *
 * @method     \DB\MailingQuery|\DB\VictimQuery|\DB\GroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWebConversion findOne(ConnectionInterface $con = null) Return the first ChildWebConversion matching the query
 * @method     ChildWebConversion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWebConversion matching the query, or a new ChildWebConversion object populated from the query conditions when no match is found
 *
 * @method     ChildWebConversion findOneById(int $id) Return the first ChildWebConversion filtered by the id column
 * @method     ChildWebConversion findOneByMailingId(int $mailing_id) Return the first ChildWebConversion filtered by the mailing_id column
 * @method     ChildWebConversion findOneByGroupId(int $group_id) Return the first ChildWebConversion filtered by the group_id column
 * @method     ChildWebConversion findOneByTimestamp(string $timestamp) Return the first ChildWebConversion filtered by the timestamp column
 * @method     ChildWebConversion findOneByVictimId(int $victim_id) Return the first ChildWebConversion filtered by the victim_id column
 * @method     ChildWebConversion findOneByUnknownId(string $unknown_id) Return the first ChildWebConversion filtered by the unknown_id column
 * @method     ChildWebConversion findOneByConversionName(string $conversion_name) Return the first ChildWebConversion filtered by the conversion_name column
 * @method     ChildWebConversion findOneByFormData(string $form_data) Return the first ChildWebConversion filtered by the form_data column
 * @method     ChildWebConversion findOneByUniqueId(string $unique_id) Return the first ChildWebConversion filtered by the unique_id column *

 * @method     ChildWebConversion requirePk($key, ConnectionInterface $con = null) Return the ChildWebConversion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOne(ConnectionInterface $con = null) Return the first ChildWebConversion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWebConversion requireOneById(int $id) Return the first ChildWebConversion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByMailingId(int $mailing_id) Return the first ChildWebConversion filtered by the mailing_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByGroupId(int $group_id) Return the first ChildWebConversion filtered by the group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByTimestamp(string $timestamp) Return the first ChildWebConversion filtered by the timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByVictimId(int $victim_id) Return the first ChildWebConversion filtered by the victim_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByUnknownId(string $unknown_id) Return the first ChildWebConversion filtered by the unknown_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByConversionName(string $conversion_name) Return the first ChildWebConversion filtered by the conversion_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByFormData(string $form_data) Return the first ChildWebConversion filtered by the form_data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWebConversion requireOneByUniqueId(string $unique_id) Return the first ChildWebConversion filtered by the unique_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWebConversion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWebConversion objects based on current ModelCriteria
 * @method     ChildWebConversion[]|ObjectCollection findById(int $id) Return ChildWebConversion objects filtered by the id column
 * @method     ChildWebConversion[]|ObjectCollection findByMailingId(int $mailing_id) Return ChildWebConversion objects filtered by the mailing_id column
 * @method     ChildWebConversion[]|ObjectCollection findByGroupId(int $group_id) Return ChildWebConversion objects filtered by the group_id column
 * @method     ChildWebConversion[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildWebConversion objects filtered by the timestamp column
 * @method     ChildWebConversion[]|ObjectCollection findByVictimId(int $victim_id) Return ChildWebConversion objects filtered by the victim_id column
 * @method     ChildWebConversion[]|ObjectCollection findByUnknownId(string $unknown_id) Return ChildWebConversion objects filtered by the unknown_id column
 * @method     ChildWebConversion[]|ObjectCollection findByConversionName(string $conversion_name) Return ChildWebConversion objects filtered by the conversion_name column
 * @method     ChildWebConversion[]|ObjectCollection findByFormData(string $form_data) Return ChildWebConversion objects filtered by the form_data column
 * @method     ChildWebConversion[]|ObjectCollection findByUniqueId(string $unique_id) Return ChildWebConversion objects filtered by the unique_id column
 * @method     ChildWebConversion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WebConversionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\WebConversionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\WebConversion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWebConversionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWebConversionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWebConversionQuery) {
            return $criteria;
        }
        $query = new ChildWebConversionQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildWebConversion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WebConversionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = WebConversionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebConversion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, mailing_id, group_id, timestamp, victim_id, unknown_id, conversion_name, form_data, unique_id FROM WebConversions WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildWebConversion $obj */
            $obj = new ChildWebConversion();
            $obj->hydrate($row);
            WebConversionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildWebConversion|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WebConversionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WebConversionTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the mailing_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMailingId(1234); // WHERE mailing_id = 1234
     * $query->filterByMailingId(array(12, 34)); // WHERE mailing_id IN (12, 34)
     * $query->filterByMailingId(array('min' => 12)); // WHERE mailing_id > 12
     * </code>
     *
     * @see       filterByMailing()
     *
     * @param     mixed $mailingId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByMailingId($mailingId = null, $comparison = null)
    {
        if (is_array($mailingId)) {
            $useMinMax = false;
            if (isset($mailingId['min'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_MAILING_ID, $mailingId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mailingId['max'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_MAILING_ID, $mailingId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_MAILING_ID, $mailingId, $comparison);
    }

    /**
     * Filter the query on the group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupId(1234); // WHERE group_id = 1234
     * $query->filterByGroupId(array(12, 34)); // WHERE group_id IN (12, 34)
     * $query->filterByGroupId(array('min' => 12)); // WHERE group_id > 12
     * </code>
     *
     * @see       filterByGroup()
     *
     * @param     mixed $groupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByGroupId($groupId = null, $comparison = null)
    {
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_GROUP_ID, $groupId, $comparison);
    }

    /**
     * Filter the query on the timestamp column
     *
     * Example usage:
     * <code>
     * $query->filterByTimestamp('2011-03-14'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp('now'); // WHERE timestamp = '2011-03-14'
     * $query->filterByTimestamp(array('max' => 'yesterday')); // WHERE timestamp > '2011-03-13'
     * </code>
     *
     * @param     mixed $timestamp The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the victim_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVictimId(1234); // WHERE victim_id = 1234
     * $query->filterByVictimId(array(12, 34)); // WHERE victim_id IN (12, 34)
     * $query->filterByVictimId(array('min' => 12)); // WHERE victim_id > 12
     * </code>
     *
     * @see       filterByVictim()
     *
     * @param     mixed $victimId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByVictimId($victimId = null, $comparison = null)
    {
        if (is_array($victimId)) {
            $useMinMax = false;
            if (isset($victimId['min'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_VICTIM_ID, $victimId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($victimId['max'])) {
                $this->addUsingAlias(WebConversionTableMap::COL_VICTIM_ID, $victimId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_VICTIM_ID, $victimId, $comparison);
    }

    /**
     * Filter the query on the unknown_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUnknownId('fooValue');   // WHERE unknown_id = 'fooValue'
     * $query->filterByUnknownId('%fooValue%', Criteria::LIKE); // WHERE unknown_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unknownId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByUnknownId($unknownId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unknownId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_UNKNOWN_ID, $unknownId, $comparison);
    }

    /**
     * Filter the query on the conversion_name column
     *
     * Example usage:
     * <code>
     * $query->filterByConversionName('fooValue');   // WHERE conversion_name = 'fooValue'
     * $query->filterByConversionName('%fooValue%', Criteria::LIKE); // WHERE conversion_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $conversionName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByConversionName($conversionName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($conversionName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_CONVERSION_NAME, $conversionName, $comparison);
    }

    /**
     * Filter the query on the form_data column
     *
     * Example usage:
     * <code>
     * $query->filterByFormData('fooValue');   // WHERE form_data = 'fooValue'
     * $query->filterByFormData('%fooValue%', Criteria::LIKE); // WHERE form_data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $formData The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByFormData($formData = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($formData)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_FORM_DATA, $formData, $comparison);
    }

    /**
     * Filter the query on the unique_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUniqueId('fooValue');   // WHERE unique_id = 'fooValue'
     * $query->filterByUniqueId('%fooValue%', Criteria::LIKE); // WHERE unique_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uniqueId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByUniqueId($uniqueId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uniqueId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebConversionTableMap::COL_UNIQUE_ID, $uniqueId, $comparison);
    }

    /**
     * Filter the query by a related \DB\Mailing object
     *
     * @param \DB\Mailing|ObjectCollection $mailing The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByMailing($mailing, $comparison = null)
    {
        if ($mailing instanceof \DB\Mailing) {
            return $this
                ->addUsingAlias(WebConversionTableMap::COL_MAILING_ID, $mailing->getId(), $comparison);
        } elseif ($mailing instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebConversionTableMap::COL_MAILING_ID, $mailing->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMailing() only accepts arguments of type \DB\Mailing or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mailing relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function joinMailing($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mailing');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Mailing');
        }

        return $this;
    }

    /**
     * Use the Mailing relation Mailing object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\MailingQuery A secondary query class using the current class as primary query
     */
    public function useMailingQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMailing($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mailing', '\DB\MailingQuery');
    }

    /**
     * Filter the query by a related \DB\Victim object
     *
     * @param \DB\Victim|ObjectCollection $victim The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByVictim($victim, $comparison = null)
    {
        if ($victim instanceof \DB\Victim) {
            return $this
                ->addUsingAlias(WebConversionTableMap::COL_VICTIM_ID, $victim->getId(), $comparison);
        } elseif ($victim instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebConversionTableMap::COL_VICTIM_ID, $victim->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByVictim() only accepts arguments of type \DB\Victim or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Victim relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function joinVictim($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Victim');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Victim');
        }

        return $this;
    }

    /**
     * Use the Victim relation Victim object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\VictimQuery A secondary query class using the current class as primary query
     */
    public function useVictimQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVictim($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Victim', '\DB\VictimQuery');
    }

    /**
     * Filter the query by a related \DB\Group object
     *
     * @param \DB\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWebConversionQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = null)
    {
        if ($group instanceof \DB\Group) {
            return $this
                ->addUsingAlias(WebConversionTableMap::COL_GROUP_ID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebConversionTableMap::COL_GROUP_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByGroup() only accepts arguments of type \DB\Group or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Group relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function joinGroup($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Group');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Group');
        }

        return $this;
    }

    /**
     * Use the Group relation Group object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Group', '\DB\GroupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWebConversion $webConversion Object to remove from the list of results
     *
     * @return $this|ChildWebConversionQuery The current query, for fluid interface
     */
    public function prune($webConversion = null)
    {
        if ($webConversion) {
            $this->addUsingAlias(WebConversionTableMap::COL_ID, $webConversion->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the WebConversions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WebConversionTableMap::clearInstancePool();
            WebConversionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WebConversionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WebConversionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WebConversionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WebConversionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WebConversionQuery
