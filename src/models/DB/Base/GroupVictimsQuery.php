<?php

namespace DB\Base;

use \Exception;
use \PDO;
use DB\GroupVictims as ChildGroupVictims;
use DB\GroupVictimsQuery as ChildGroupVictimsQuery;
use DB\Map\GroupVictimsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Group_Victims' table.
 *
 *
 *
 * @method     ChildGroupVictimsQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     ChildGroupVictimsQuery orderByVictimId($order = Criteria::ASC) Order by the victim_id column
 *
 * @method     ChildGroupVictimsQuery groupByGroupId() Group by the group_id column
 * @method     ChildGroupVictimsQuery groupByVictimId() Group by the victim_id column
 *
 * @method     ChildGroupVictimsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildGroupVictimsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildGroupVictimsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildGroupVictimsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildGroupVictimsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildGroupVictimsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildGroupVictimsQuery leftJoinGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the Group relation
 * @method     ChildGroupVictimsQuery rightJoinGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Group relation
 * @method     ChildGroupVictimsQuery innerJoinGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the Group relation
 *
 * @method     ChildGroupVictimsQuery joinWithGroup($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Group relation
 *
 * @method     ChildGroupVictimsQuery leftJoinWithGroup() Adds a LEFT JOIN clause and with to the query using the Group relation
 * @method     ChildGroupVictimsQuery rightJoinWithGroup() Adds a RIGHT JOIN clause and with to the query using the Group relation
 * @method     ChildGroupVictimsQuery innerJoinWithGroup() Adds a INNER JOIN clause and with to the query using the Group relation
 *
 * @method     ChildGroupVictimsQuery leftJoinVictim($relationAlias = null) Adds a LEFT JOIN clause to the query using the Victim relation
 * @method     ChildGroupVictimsQuery rightJoinVictim($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Victim relation
 * @method     ChildGroupVictimsQuery innerJoinVictim($relationAlias = null) Adds a INNER JOIN clause to the query using the Victim relation
 *
 * @method     ChildGroupVictimsQuery joinWithVictim($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Victim relation
 *
 * @method     ChildGroupVictimsQuery leftJoinWithVictim() Adds a LEFT JOIN clause and with to the query using the Victim relation
 * @method     ChildGroupVictimsQuery rightJoinWithVictim() Adds a RIGHT JOIN clause and with to the query using the Victim relation
 * @method     ChildGroupVictimsQuery innerJoinWithVictim() Adds a INNER JOIN clause and with to the query using the Victim relation
 *
 * @method     \DB\GroupQuery|\DB\VictimQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildGroupVictims findOne(ConnectionInterface $con = null) Return the first ChildGroupVictims matching the query
 * @method     ChildGroupVictims findOneOrCreate(ConnectionInterface $con = null) Return the first ChildGroupVictims matching the query, or a new ChildGroupVictims object populated from the query conditions when no match is found
 *
 * @method     ChildGroupVictims findOneByGroupId(int $group_id) Return the first ChildGroupVictims filtered by the group_id column
 * @method     ChildGroupVictims findOneByVictimId(int $victim_id) Return the first ChildGroupVictims filtered by the victim_id column *

 * @method     ChildGroupVictims requirePk($key, ConnectionInterface $con = null) Return the ChildGroupVictims by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupVictims requireOne(ConnectionInterface $con = null) Return the first ChildGroupVictims matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupVictims requireOneByGroupId(int $group_id) Return the first ChildGroupVictims filtered by the group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildGroupVictims requireOneByVictimId(int $victim_id) Return the first ChildGroupVictims filtered by the victim_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildGroupVictims[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildGroupVictims objects based on current ModelCriteria
 * @method     ChildGroupVictims[]|ObjectCollection findByGroupId(int $group_id) Return ChildGroupVictims objects filtered by the group_id column
 * @method     ChildGroupVictims[]|ObjectCollection findByVictimId(int $victim_id) Return ChildGroupVictims objects filtered by the victim_id column
 * @method     ChildGroupVictims[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class GroupVictimsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \DB\Base\GroupVictimsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\DB\\GroupVictims', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildGroupVictimsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildGroupVictimsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildGroupVictimsQuery) {
            return $criteria;
        }
        $query = new ChildGroupVictimsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$group_id, $victim_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildGroupVictims|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(GroupVictimsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = GroupVictimsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildGroupVictims A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT group_id, victim_id FROM Group_Victims WHERE group_id = :p0 AND victim_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildGroupVictims $obj */
            $obj = new ChildGroupVictims();
            $obj->hydrate($row);
            GroupVictimsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildGroupVictims|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(GroupVictimsTableMap::COL_GROUP_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(GroupVictimsTableMap::COL_VICTIM_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByGroupId($groupId = null, $comparison = null)
    {
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $groupId, $comparison);
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
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByVictimId($victimId = null, $comparison = null)
    {
        if (is_array($victimId)) {
            $useMinMax = false;
            if (isset($victimId['min'])) {
                $this->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $victimId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($victimId['max'])) {
                $this->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $victimId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $victimId, $comparison);
    }

    /**
     * Filter the query by a related \DB\Group object
     *
     * @param \DB\Group|ObjectCollection $group The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByGroup($group, $comparison = null)
    {
        if ($group instanceof \DB\Group) {
            return $this
                ->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $group->getId(), $comparison);
        } elseif ($group instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupVictimsTableMap::COL_GROUP_ID, $group->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function joinGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Group', '\DB\GroupQuery');
    }

    /**
     * Filter the query by a related \DB\Victim object
     *
     * @param \DB\Victim|ObjectCollection $victim The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function filterByVictim($victim, $comparison = null)
    {
        if ($victim instanceof \DB\Victim) {
            return $this
                ->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $victim->getId(), $comparison);
        } elseif ($victim instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(GroupVictimsTableMap::COL_VICTIM_ID, $victim->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function joinVictim($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useVictimQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinVictim($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Victim', '\DB\VictimQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildGroupVictims $groupVictims Object to remove from the list of results
     *
     * @return $this|ChildGroupVictimsQuery The current query, for fluid interface
     */
    public function prune($groupVictims = null)
    {
        if ($groupVictims) {
            $this->addCond('pruneCond0', $this->getAliasedColName(GroupVictimsTableMap::COL_GROUP_ID), $groupVictims->getGroupId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(GroupVictimsTableMap::COL_VICTIM_ID), $groupVictims->getVictimId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Group_Victims table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(GroupVictimsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            GroupVictimsTableMap::clearInstancePool();
            GroupVictimsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(GroupVictimsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(GroupVictimsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            GroupVictimsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            GroupVictimsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // GroupVictimsQuery
