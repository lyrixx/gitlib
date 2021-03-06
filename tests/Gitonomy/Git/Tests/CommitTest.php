<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git\Tests;

use Gitonomy\Git\Commit;
use Gitonomy\Git\Diff;

class CommitTest extends AbstractTest
{
    /**
     * @dataProvider provideFoobar
     */
    public function testGetDiff($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $diff = $commit->getDiff();

        $this->assertTrue($diff instanceof Diff, "getDiff() returns a Diff object");
        $this->assertEquals(array($commit->getHash()), $diff->getRevisions(), "getDiff() revision is correct");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetHash($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals(self::LONGFILE_COMMIT, $commit->getHash());
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetShortHash($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('4f17752', $commit->getShortHash(), "Short hash");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetParentHashes_WithNoParent($repository)
    {
        $commit = $repository->getCommit(self::INITIAL_COMMIT);

        $this->assertEquals(0, count($commit->getParentHashes()), "No parent on initial commit");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetParentHashes_WithOneParent($repository)
    {
        $commit  = $repository->getCommit(self::LONGFILE_COMMIT);
        $parents = $commit->getParentHashes();

        $this->assertEquals(1, count($parents), "One parent found");
        $this->assertEquals(self::BEFORE_LONGFILE_COMMIT, $parents[0], "Parent hash is correct");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetParents_WithOneParent($repository)
    {
        $commit  = $repository->getCommit(self::LONGFILE_COMMIT);
        $parents = $commit->getParents();

        $this->assertEquals(1, count($parents), "One parent found");
        $this->assertTrue($parents[0] instanceof Commit, "First parent is a Commit object");
        $this->assertEquals(self::BEFORE_LONGFILE_COMMIT, $parents[0]->getHash(), "First parents's hash is correct");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetTree($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('b06890c7b10904979d2f69613c2ccda30aafe262', $commit->getTreeHash(), "Tree hash is correct");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetAuthorName($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('alice', $commit->getAuthorName(), "Author name");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetAuthorEmail($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('alice@example.org', $commit->getAuthorEmail(), "Author email");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetAuthorDate($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('2012-12-31 14:21:03', $commit->getAuthorDate()->format('Y-m-d H:i:s'), 'Author date');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetCommitterName($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('alice', $commit->getCommitterName(), "Committer name");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetCommitterEmail($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('alice@example.org', $commit->getCommitterEmail(), "Committer email");
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetCommitterDate($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('2012-12-31 14:21:03', $commit->getCommitterDate()->format('Y-m-d H:i:s'), 'Committer date');
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetMessage($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('add a long file'."\n", $commit->getMessage());
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetShortMessage($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $this->assertEquals('add a long file', $commit->getShortMessage());
    }

    /**
     * @dataProvider provideFoobar
     */
    public function testGetLastModification($repository)
    {
        $commit = $repository->getCommit(self::LONGFILE_COMMIT);

        $lastModification = $commit->getLastModification('image.jpg');

        $this->assertTrue($lastModification instanceof Commit, "Last modification is a Commit object");
        $this->assertEquals(self::BEFORE_LONGFILE_COMMIT, $lastModification->getHash(), "Last modification is current commit");
    }
}
