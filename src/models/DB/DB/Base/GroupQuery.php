<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\Group as ChildGroup;
use DB\GroupQuery as ChildGroupQuery;
use DB\Map\GroupTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Groups' table.
 *
 *
 *
 * @method     ChildGroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildGroupQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildGroupQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method     ChildGroupQuery groupById() Group by the id column
 * @method     ChildGroupQuery groupByName() Group by the name column
 * @method     ChildGroupQuery groupByDescription() Group by the description column
 *
 * @method     ChildGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGroupQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGroupQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGroupQuery leftJoinWebVisit($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebVisit relation
 * @method     ChildGroupQuery rightJoinWebVisit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebVisit relation
 * @method     ChildGroupQuery innerJoinWebVisit($relationAlias = null) Adds a INNER JOIN clause to the query using the WebVisit relation
 *
 * @method     ChildGroupQuery joinWithWebVisit($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebVisit relation
 *
 * @method     ChildGroupQuery leftJoinWithWebVisit() Adds a LEFT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildGroupQuery rightJoinWithWebVisit() Adds a RIGHT JOIN clause and with to the query using the WebVisit relation
 * @method     ChildGroupQuery innerJoinWithWebVisit() Adds a INNER JOIN clause and with to the query using the WebVisit relation
 *
 * @method     ChildGroupQuery leftJoinWebConversion($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebConversion relation
 * @method     ChildGroupQuery rightJoinWebConversion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebConversion relation
 * @method     ChildGroupQuery innerJoinWebConversion($relationAlias = null) Adds a INNER JOIN clause to the query using the WebConversion relation
 *
 * @method     ChildGroupQuery joinWithWebConversion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WebConversion relation
 *
 * @method     ChildGroupQuery leftJoinWithWebConversion() Adds a LEFT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildGroupQuery rightJoinWithWebConversion() Adds a RIGHT JOIN clause and with to the query using the WebConversion relation
 * @method     ChildGroupQuery innerJoinWithWebConversion() Adds a INNER JOIN clause and with to the query using the WebConversion relation
 *
 * @method     ChildGroupQuery leftJoinUserGroups($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroups relation
 * @method     ChildGroupQuery rightJoinUserGroups($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroups relation
 * @method     ChildGroupQuery innerJoinUserGroups($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroups relation
 *
 * @method     ChildGroupQuery joinWithUserGroups($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserGroups relation
 *
 * @method     ChildGroupQuery leftJoinWithUserGroups() Adds a LEFT JOIN clause and with to the query using the UserGroups relation
 * @method     ChildGroupQuery rightJoinWithUserGroups() Adds a RIGHT JOIN clause and with to the query using the UserGroups relation
 * @method     ChildGroupQuery innerJoinWithUserGroups() Adds a INNER JOIN clause and with to the query using the UserGroups relation
 *
 * @method     ChildGroupQuery leftJoinGroupVictims($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupVictims relation
 * @method     ChildGroupQuery rightJoinGroupVictims($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupVictims relation
 * @method     ChildGroupQuery innerJoinGroupVictims($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupVictims relation
 *
 * @method     ChildGroupQuery joinWithGroupVictims($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupVictims relation
 *
 * @method     ChildGroupQuery leftJoinWithGroupVictims() Adds a LEFT JOIN clause and with to the query using the GroupVictims relation
 * @method     ChildGroupQuery rightJoinWithGroupVictims() Adds a RIGHT JOIN clause and with to the query using the GroupVictims relation
 * @method     ChildGroupQuery innerJoinWithGroupVictims() Adds a INNER JOIN clause and with to the query using the GroupVictims relation
 *
 * @method     ChildGroupQuery leftJoinVictimMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the VictimMailings relation
 * @method     ChildGroupQuery rightJoinVictimMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the VictimMailings relation
 * @method     ChildGroupQuery innerJoinVictimMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the VictimMailings relation
 *
 * @method     ChildGroupQuery joinWithVictimMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the VictimMailings relation
 *
 * @method     ChildGroupQuery leftJoinWithVictimMailings() Adds a LEFT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildGroupQuery rightJoinWithVictimMailings() Adds a RIGHT JOIN clause and with to the query using the VictimMailings relation
 * @method     ChildGroupQuery innerJoinWithVictimMailings() Adds a INNER JOIN clause and with to the query using the VictimMailings relation
 *
 * @method     ChildGroupQuery leftJoinGroupMailings($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupMailings relation
 * @method     ChildGroupQuery rightJoinGroupMailings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupMailings relation
 * @method     ChildGroupQuery innerJoinGroupMailings($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupMailings relation
 *
 * @method     ChildGroupQuery joinWithGroupMailings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the GroupMailings relation
 *
 * @method     ChildGroupQuery leftJoinWithGroupMailings() Adds a LEFT JOIN clause and with to the query using the GroupMailings relation
 * @method     ChildGroupQuery rightJoinWithGroupMailings() Adds a RIGHT JOIN clause and with to the query using the GroupMailings relation
 * @method     ChildGroupQuery innerJoinWithGroupMailings() Adds a INNER JOIN clause and with to the query using the GroupMailings relation
 *
 * @method     \DB\WebVisitQuery|\DB\WebConversionQuery|\DB\UserGroupsQuery|\DB\GroupVictimsQuery|\DB\VictimMailingsQuery|\DB\GroupMailingsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroup findOne(ConnectionInterface $con = null) Return the first ChildGroup matching the query
 * @method     ChildGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroup matching the query, or a new ChildGroup object populated from the query conditions when no match is found
 *
 * @method     ChildGroup findOneById(int $id) Return the first ChildGroup filtered by the id column
 * @method     ChildGroup findOneByName(string $name) Return the first ChildGroup filtered by the name column
 * @method     ChildGroup findOneByDescription(string $description) Return the first ChildGroup filtered by the description column *

 * @method     ChildGroup requirePk($key, ConnectionInterface $con = null) Return the ChildGroup by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOne(ConnectionInterface $con = null) Return the first ChildGroup matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroup requireOneById(int $id) Return the first ChildGroup filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOneByName(string $name) Return the first ChildGroup filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroup requireOneByDescription(string $description) Return the first ChildGroup filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroup objects based on current ModelCriteria
 * @method     ChildGroup[]|ObjectCollection findById(int $id) Return ChildGroup objects filtered by the id column
 * @method     ChildGroup[]|ObjectCollection findByName(string $name) Return ChildGroup objects filtered by the name column
 * @method     ChildGroup[]|ObjectCollection findByDescription(string $description) Return ChildGroup objects filtered by the description column
 * @method     ChildGroup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\GroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\Group', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupQuery) {
            return $criteria;
        }
        $query = new ChildGroupQuery();
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
     * @return ChildGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GroupTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildGroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description FROM Groups WHERE id = :p0';
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
            /** @var ChildGroup $obj */
            $obj = new ChildGroup();
            $obj->hydrate($row);
            GroupTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildGroup|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(GroupTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(GroupTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(GroupTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(GroupTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related \DB\WebVisit object
     *
     * @param \DB\WebVisit|ObjectCollection $webVisit the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByWebVisit($webVisit, $comparison = null)
    {
        if ($webVisit instanceof \DB\WebVisit) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $webVisit->getGroupId(), $comparison);
        } elseif ($webVisit instanceof ObjectCollection) {
            return $this
                ->useWebVisitQuery()
                ->filterByPrimaryKeys($webVisit->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebVisit() only accepts arguments of type \DB\WebVisit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WebVisit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinWebVisit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WebVisit');

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
            $this->addJoinObject($join, 'WebVisit');
        }

        return $this;
    }

    /**
     * Use the WebVisit relation WebVisit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\WebVisitQuery A secondary query class using the current class as primary query
     */
    public function useWebVisitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWebVisit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebVisit', '\DB\WebVisitQuery');
    }

    /**
     * Filter the query by a related \DB\WebConversion object
     *
     * @param \DB\WebConversion|ObjectCollection $webConversion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByWebConversion($webConversion, $comparison = null)
    {
        if ($webConversion instanceof \DB\WebConversion) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $webConversion->getGroupId(), $comparison);
        } elseif ($webConversion instanceof ObjectCollection) {
            return $this
                ->useWebConversionQuery()
                ->filterByPrimaryKeys($webConversion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebConversion() only accepts arguments of type \DB\WebConversion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WebConversion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinWebConversion($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WebConversion');

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
            $this->addJoinObject($join, 'WebConversion');
        }

        return $this;
    }

    /**
     * Use the WebConversion relation WebConversion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\WebConversionQuery A secondary query class using the current class as primary query
     */
    public function useWebConversionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWebConversion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebConversion', '\DB\WebConversionQuery');
    }

    /**
     * Filter the query by a related \DB\UserGroups object
     *
     * @param \DB\UserGroups|ObjectCollection $userGroups the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByUserGroups($userGroups, $comparison = null)
    {
        if ($userGroups instanceof \DB\UserGroups) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $userGroups->getGroupId(), $comparison);
        } elseif ($userGroups instanceof ObjectCollection) {
            return $this
                ->useUserGroupsQuery()
                ->filterByPrimaryKeys($userGroups->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroups() only accepts arguments of type \DB\UserGroups or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroups relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinUserGroups($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroups');

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
            $this->addJoinObject($join, 'UserGroups');
        }

        return $this;
    }

    /**
     * Use the UserGroups relation UserGroups object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\UserGroupsQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserGroups($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroups', '\DB\UserGroupsQuery');
    }

    /**
     * Filter the query by a related \DB\GroupVictims object
     *
     * @param \DB\GroupVictims|ObjectCollection $groupVictims the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByGroupVictims($groupVictims, $comparison = null)
    {
        if ($groupVictims instanceof \DB\GroupVictims) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $groupVictims->getGroupId(), $comparison);
        } elseif ($groupVictims instanceof ObjectCollection) {
            return $this
                ->useGroupVictimsQuery()
                ->filterByPrimaryKeys($groupVictims->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupVictims() only accepts arguments of type \DB\GroupVictims or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupVictims relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinGroupVictims($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupVictims');

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
            $this->addJoinObject($join, 'GroupVictims');
        }

        return $this;
    }

    /**
     * Use the GroupVictims relation GroupVictims object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\GroupVictimsQuery A secondary query class using the current class as primary query
     */
    public function useGroupVictimsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupVictims($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupVictims', '\DB\GroupVictimsQuery');
    }

    /**
     * Filter the query by a related \DB\VictimMailings object
     *
     * @param \DB\VictimMailings|ObjectCollection $victimMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByVictimMailings($victimMailings, $comparison = null)
    {
        if ($victimMailings instanceof \DB\VictimMailings) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $victimMailings->getGroupId(), $comparison);
        } elseif ($victimMailings instanceof ObjectCollection) {
            return $this
                ->useVictimMailingsQuery()
                ->filterByPrimaryKeys($victimMailings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByVictimMailings() only accepts arguments of type \DB\VictimMailings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the VictimMailings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinVictimMailings($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('VictimMailings');

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
            $this->addJoinObject($join, 'VictimMailings');
        }

        return $this;
    }

    /**
     * Use the VictimMailings relation VictimMailings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\VictimMailingsQuery A secondary query class using the current class as primary query
     */
    public function useVictimMailingsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinVictimMailings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'VictimMailings', '\DB\VictimMailingsQuery');
    }

    /**
     * Filter the query by a related \DB\GroupMailings object
     *
     * @param \DB\GroupMailings|ObjectCollection $groupMailings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByGroupMailings($groupMailings, $comparison = null)
    {
        if ($groupMailings instanceof \DB\GroupMailings) {
            return $this
                ->addUsingAlias(GroupTableMap::COL_ID, $groupMailings->getGroupId(), $comparison);
        } elseif ($groupMailings instanceof ObjectCollection) {
            return $this
                ->useGroupMailingsQuery()
                ->filterByPrimaryKeys($groupMailings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupMailings() only accepts arguments of type \DB\GroupMailings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupMailings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function joinGroupMailings($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupMailings');

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
            $this->addJoinObject($join, 'GroupMailings');
        }

        return $this;
    }

    /**
     * Use the GroupMailings relation GroupMailings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DB\GroupMailingsQuery A secondary query class using the current class as primary query
     */
    public function useGroupMailingsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupMailings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupMailings', '\DB\GroupMailingsQuery');
    }

    /**
     * Filter the query by a related User object
     * using the User_Groups table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserGroupsQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Victim object
     * using the Group_Victims table as cross reference
     *
     * @param Victim $victim the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByVictim($victim, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGroupVictimsQuery()
            ->filterByVictim($victim, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Mailing object
     * using the Group_Mailings table as cross reference
     *
     * @param Mailing $mailing the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildGroupQuery The current query, for fluid interface
     */
    public function filterByMailing($mailing, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useGroupMailingsQuery()
            ->filterByMailing($mailing, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGroup $group Object to remove from the list of results
     *
     * @return $this|ChildGroupQuery The current query, for fluid interface
     */
    public function prune($group = null)
    {
        if ($group) {
            $this->addUsingAlias(GroupTableMap::COL_ID, $group->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Groups table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupTableMap::clearInstancePool();
            GroupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupQuery
