<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
	// define public methods as commands

	function scripts() {

		$this->taskMinify('assets/maps.js')
		     ->to('dist/scripts/maps.min.js')
		     ->run();

	}

	function tests()
	{

		$this->taskExec('mysql -e "CREATE DATABASE IF NOT EXISTS test_db"')->run();
		$this->taskExec('mysql -e "GRANT ALL ON test_db.* to \'root\'@\'%\'"')->run();
		$this->taskSvnStack()
		     ->checkout('https://develop.svn.wordpress.org/tags/4.8.3 wp-tests')
		     ->run();

		$this->setTestConfig();
		$this->phpunit();

	}

	function phpunit()
	{
		$this->taskPhpUnit('vendor/bin/phpunit')
		     ->configFile('tests/phpunit.xml.dist')
		     ->envVars(array('WP_TESTS_DIR' => 'wp-tests'))
		     ->run();
	}

	private function setTestConfig()
	{

		if (file_exists('wp-tests/wp-tests-config-sample.php')) {
			copy('wp-tests/wp-tests-config-sample.php', 'wp-tests/wp-tests-config.php');
		}

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('youremptytestdbnamehere')
		     ->to('test_db')
		     ->run();

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('yourusernamehere')
		     ->to('root')
		     ->run();

		$this->taskReplaceInFile( 'wp-tests/wp-tests-config.php')
		     ->from('yourpasswordhere')
		     ->to('')
		     ->run();
	}

}