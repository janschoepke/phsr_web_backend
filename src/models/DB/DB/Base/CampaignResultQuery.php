<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\CampaignResult as ChildCampaignResult;
use DB\CampaignResultQuery as ChildCampaignResultQuery;
use DB\Map\CampaignResultTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'CampaignResults' table.
 *
 *
 *
 * @method     ChildCampaignResultQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCampaignResultQuery orderByTimestamp($order = Criteria::ASC) Order by the timestamp column
 * @method     ChildCampaignResultQuery orderByComputerName($order = Criteria::ASC) Order by the computer_name column
 * @method     ChildCampaignResultQuery orderByUserName($order = Criteria::ASC) Order by the user_name column
 * @method     ChildCampaignResultQuery orderByInternalIp($order = Criteria::ASC) Order by the internal_ip column
 * @method     ChildCampaignResultQuery orderByExternalIp($order = Criteria::ASC) Order by the external_ip column
 * @method     ChildCampaignResultQuery orderByOsVersion($order = Criteria::ASC) Order by the os_version column
 * @method     ChildCampaignResultQuery orderByCampaignId($order = Criteria::ASC) Order by the campaign_id column
 *
 * @method     ChildCampaignResultQuery groupById() Group by the id column
 * @method     ChildCampaignResultQuery groupByTimestamp() Group by the timestamp column
 * @method     ChildCampaignResultQuery groupByComputerName() Group by the computer_name column
 * @method     ChildCampaignResultQuery groupByUserName() Group by the user_name column
 * @method     ChildCampaignResultQuery groupByInternalIp() Group by the internal_ip column
 * @method     ChildCampaignResultQuery groupByExternalIp() Group by the external_ip column
 * @method     ChildCampaignResultQuery groupByOsVersion() Group by the os_version column
 * @method     ChildCampaignResultQuery groupByCampaignId() Group by the campaign_id column
 *
 * @method     ChildCampaignResultQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCampaignResultQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCampaignResultQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCampaignResultQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCampaignResultQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCampaignResultQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCampaignResultQuery leftJoinMalwareCampaign($relationAlias = null) Adds a LEFT JOIN clause to the query using the MalwareCampaign relation
 * @method     ChildCampaignResultQuery rightJoinMalwareCampaign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MalwareCampaign relation
 * @method     ChildCampaignResultQuery innerJoinMalwareCampaign($relationAlias = null) Adds a INNER JOIN clause to the query using the MalwareCampaign relation
 *
 * @method     ChildCampaignResultQuery joinWithMalwareCampaign($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MalwareCampaign relation
 *
 * @method     ChildCampaignResultQuery leftJoinWithMalwareCampaign() Adds a LEFT JOIN clause and with to the query using the MalwareCampaign relation
 * @method     ChildCampaignResultQuery rightJoinWithMalwareCampaign() Adds a RIGHT JOIN clause and with to the query using the MalwareCampaign relation
 * @method     ChildCampaignResultQuery innerJoinWithMalwareCampaign() Adds a INNER JOIN clause and with to the query using the MalwareCampaign relation
 *
 * @method     \DB\MalwareCampaignQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCampaignResult findOne(ConnectionInterface $con = null) Return the first ChildCampaignResult matching the query
 * @method     ChildCampaignResult findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCampaignResult matching the query, or a new ChildCampaignResult object populated from the query conditions when no match is found
 *
 * @method     ChildCampaignResult findOneById(int $id) Return the first ChildCampaignResult filtered by the id column
 * @method     ChildCampaignResult findOneByTimestamp(string $timestamp) Return the first ChildCampaignResult filtered by the timestamp column
 * @method     ChildCampaignResult findOneByComputerName(string $computer_name) Return the first ChildCampaignResult filtered by the computer_name column
 * @method     ChildCampaignResult findOneByUserName(string $user_name) Return the first ChildCampaignResult filtered by the user_name column
 * @method     ChildCampaignResult findOneByInternalIp(string $internal_ip) Return the first ChildCampaignResult filtered by the internal_ip column
 * @method     ChildCampaignResult findOneByExternalIp(string $external_ip) Return the first ChildCampaignResult filtered by the external_ip column
 * @method     ChildCampaignResult findOneByOsVersion(string $os_version) Return the first ChildCampaignResult filtered by the os_version column
 * @method     ChildCampaignResult findOneByCampaignId(int $campaign_id) Return the first ChildCampaignResult filtered by the campaign_id column *

 * @method     ChildCampaignResult requirePk($key, ConnectionInterface $con = null) Return the ChildCampaignResult by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOne(ConnectionInterface $con = null) Return the first ChildCampaignResult matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCampaignResult requireOneById(int $id) Return the first ChildCampaignResult filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByTimestamp(string $timestamp) Return the first ChildCampaignResult filtered by the timestamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByComputerName(string $computer_name) Return the first ChildCampaignResult filtered by the computer_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByUserName(string $user_name) Return the first ChildCampaignResult filtered by the user_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByInternalIp(string $internal_ip) Return the first ChildCampaignResult filtered by the internal_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByExternalIp(string $external_ip) Return the first ChildCampaignResult filtered by the external_ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByOsVersion(string $os_version) Return the first ChildCampaignResult filtered by the os_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCampaignResult requireOneByCampaignId(int $campaign_id) Return the first ChildCampaignResult filtered by the campaign_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCampaignResult[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCampaignResult objects based on current ModelCriteria
 * @method     ChildCampaignResult[]|ObjectCollection findById(int $id) Return ChildCampaignResult objects filtered by the id column
 * @method     ChildCampaignResult[]|ObjectCollection findByTimestamp(string $timestamp) Return ChildCampaignResult objects filtered by the timestamp column
 * @method     ChildCampaignResult[]|ObjectCollection findByComputerName(string $computer_name) Return ChildCampaignResult objects filtered by the computer_name column
 * @method     ChildCampaignResult[]|ObjectCollection findByUserName(string $user_name) Return ChildCampaignResult objects filtered by the user_name column
 * @method     ChildCampaignResult[]|ObjectCollection findByInternalIp(string $internal_ip) Return ChildCampaignResult objects filtered by the internal_ip column
 * @method     ChildCampaignResult[]|ObjectCollection findByExternalIp(string $external_ip) Return ChildCampaignResult objects filtered by the external_ip column
 * @method     ChildCampaignResult[]|ObjectCollection findByOsVersion(string $os_version) Return ChildCampaignResult objects filtered by the os_version column
 * @method     ChildCampaignResult[]|ObjectCollection findByCampaignId(int $campaign_id) Return ChildCampaignResult objects filtered by the campaign_id column
 * @method     ChildCampaignResult[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CampaignResultQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\CampaignResultQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\CampaignResult', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCampaignResultQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCampaignResultQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCampaignResultQuery) {
            return $criteria;
        }
        $query = new ChildCampaignResultQuery();
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
     * @return ChildCampaignResult|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CampaignResultTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CampaignResultTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCampaignResult A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, timestamp, computer_name, user_name, internal_ip, external_ip, os_version, campaign_id FROM CampaignResults WHERE id = :p0';
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
            /** @var ChildCampaignResult $obj */
            $obj = new ChildCampaignResult();
            $obj->hydrate($row);
            CampaignResultTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCampaignResult|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CampaignResultTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CampaignResultTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByTimestamp($timestamp = null, $comparison = null)
    {
        if (is_array($timestamp)) {
            $useMinMax = false;
            if (isset($timestamp['min'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_TIMESTAMP, $timestamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timestamp['max'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_TIMESTAMP, $timestamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_TIMESTAMP, $timestamp, $comparison);
    }

    /**
     * Filter the query on the computer_name column
     *
     * Example usage:
     * <code>
     * $query->filterByComputerName('fooValue');   // WHERE computer_name = 'fooValue'
     * $query->filterByComputerName('%fooValue%', Criteria::LIKE); // WHERE computer_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $computerName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByComputerName($computerName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($computerName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_COMPUTER_NAME, $computerName, $comparison);
    }

    /**
     * Filter the query on the user_name column
     *
     * Example usage:
     * <code>
     * $query->filterByUserName('fooValue');   // WHERE user_name = 'fooValue'
     * $query->filterByUserName('%fooValue%', Criteria::LIKE); // WHERE user_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userName The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByUserName($userName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_USER_NAME, $userName, $comparison);
    }

    /**
     * Filter the query on the internal_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByInternalIp('fooValue');   // WHERE internal_ip = 'fooValue'
     * $query->filterByInternalIp('%fooValue%', Criteria::LIKE); // WHERE internal_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $internalIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByInternalIp($internalIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($internalIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_INTERNAL_IP, $internalIp, $comparison);
    }

    /**
     * Filter the query on the external_ip column
     *
     * Example usage:
     * <code>
     * $query->filterByExternalIp('fooValue');   // WHERE external_ip = 'fooValue'
     * $query->filterByExternalIp('%fooValue%', Criteria::LIKE); // WHERE external_ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $externalIp The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByExternalIp($externalIp = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($externalIp)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_EXTERNAL_IP, $externalIp, $comparison);
    }

    /**
     * Filter the query on the os_version column
     *
     * Example usage:
     * <code>
     * $query->filterByOsVersion('fooValue');   // WHERE os_version = 'fooValue'
     * $query->filterByOsVersion('%fooValue%', Criteria::LIKE); // WHERE os_version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $osVersion The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByOsVersion($osVersion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($osVersion)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_OS_VERSION, $osVersion, $comparison);
    }

    /**
     * Filter the query on the campaign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCampaignId(1234); // WHERE campaign_id = 1234
     * $query->filterByCampaignId(array(12, 34)); // WHERE campaign_id IN (12, 34)
     * $query->filterByCampaignId(array('min' => 12)); // WHERE campaign_id > 12
     * </code>
     *
     * @see       filterByMalwareCampaign()
     *
     * @param     mixed $campaignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByCampaignId($campaignId = null, $comparison = null)
    {
        if (is_array($campaignId)) {
            $useMinMax = false;
            if (isset($campaignId['min'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_CAMPAIGN_ID, $campaignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($campaignId['max'])) {
                $this->addUsingAlias(CampaignResultTableMap::COL_CAMPAIGN_ID, $campaignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CampaignResultTableMap::COL_CAMPAIGN_ID, $campaignId, $comparison);
    }

    /**
     * Filter the query by a related \DB\MalwareCampaign object
     *
     * @param \DB\MalwareCampaign|ObjectCollection $malwareCampaign The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCampaignResultQuery The current query, for fluid interface
     */
    public function filterByMalwareCampaign($malwareCampaign, $comparison = null)
    {
        if ($malwareCampaign instanceof \DB\MalwareCampaign) {
            return $this
                ->addUsingAlias(CampaignResultTableMap::COL_CAMPAIGN_ID, $malwareCampaign->getId(), $comparison);
        } elseif ($malwareCampaign instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CampaignResultTableMap::COL_CAMPAIGN_ID, $malwareCampaign->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMalwareCampaign() only accepts arguments of type \DB\MalwareCampaign or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MalwareCampaign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function joinMalwareCampaign($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MalwareCampaign');

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
            $this->addJoinObject($join, 'MalwareCampaign');
        }

        return $this;
    }

    /**
     * Use the MalwareCampaign relation MalwareCampaign object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\MalwareCampaignQuery A secondary query class using the current class as primary query
     */
    public function useMalwareCampaignQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMalwareCampaign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MalwareCampaign', '\DB\MalwareCampaignQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCampaignResult $campaignResult Object to remove from the list of results
     *
     * @return $this|ChildCampaignResultQuery The current query, for fluid interface
     */
    public function prune($campaignResult = null)
    {
        if ($campaignResult) {
            $this->addUsingAlias(CampaignResultTableMap::COL_ID, $campaignResult->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the CampaignResults table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignResultTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CampaignResultTableMap::clearInstancePool();
            CampaignResultTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CampaignResultTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CampaignResultTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CampaignResultTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CampaignResultTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CampaignResultQuery
