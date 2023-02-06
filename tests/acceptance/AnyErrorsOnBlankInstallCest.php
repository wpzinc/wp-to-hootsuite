<?php
/**
 * Tests for errors on a blank installation
 *
 * @since   3.8.4
 */
class AnyErrorsOnBlankInstallCest
{
	/**
	 * Run common actions before running the test functions in this class.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function _before(AcceptanceTester $I)
	{
		$I->activateWPToBufferPlugin($I);
	}

	/**
	 * Check that no PHP errors or notices are displayed on the Plugin's Settings > General screen when the Plugin is activated
	 * and not configured.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function testSettingsScreen(AcceptanceTester $I)
	{
		// Go to the Plugin's Settings Screen.
		$I->amOnAdminPage('admin.php?page=wp-to-buffer');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);

	}

	/**
	 * Check that no errors are displayed on Pages > Add New, when the Plugin is activated
	 * and not configured.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function testAddNewPage(AcceptanceTester $I)
	{
		// Navigate to Pages > Add New.
		$I->amOnAdminPage('post-new.php?post_type=page');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);
	}

	/**
	 * Check that no errors are displayed on Posts > Add New, when the Plugin is activated
	 * and not configured.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function testAddNewPost(AcceptanceTester $I)
	{
		// Navigate to Pages > Add New.
		$I->amOnAdminPage('post-new.php');

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);
	}

	/**
	 * Deactivate and reset Plugin(s) after each test, if the test passes.
	 * We don't use _after, as this would provide a screenshot of the Plugin
	 * deactivation and not the true test error.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function _passed(AcceptanceTester $I)
	{
		$I->deactivateWPToBufferPlugin($I);
	}
}
