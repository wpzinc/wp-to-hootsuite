<?php
namespace Helper\Acceptance;

/**
 * Helper methods and actions related to the Plugin that
 * would be used across multiple tests.
 * These are then available using $I->{yourFunctionName}.
 *
 * @since   3.8.4
 */
class Plugin extends \Codeception\Module
{
	/**
	 * Helper method to activate the Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function activateWPToBufferPlugin($I)
	{
		$I->activateThirdPartyPlugin($I, 'wp-to-buffer');
	}

	/**
	 * Helper method to deactivate the Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function deactivateWPToBufferPlugin($I)
	{
		$I->deactivateThirdPartyPlugin($I, 'wp-to-buffer');
	}

	/**
	 * Helper method to activate a third party Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I      Tester.
	 * @param   string           $name   Plugin Slug.
	 */
	public function activateThirdPartyPlugin($I, $name)
	{
		// Login as the Administrator.
		$I->loginAsAdmin();

		// Go to the Plugins screen in the WordPress Administration interface.
		$I->amOnPluginsPage();

		// Activate the Plugin.
		$I->activatePlugin($name);

		// Check that the Plugin activated successfully.
		$I->seePluginActivated($name);

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);
	}

	/**
	 * Helper method to activate a third party Plugin, checking
	 * it activated and no errors were output.
	 *
	 * @since   3.8.4
	 *
	 * @param   AcceptanceTester $I      Tester.
	 * @param   string           $name   Plugin Slug.
	 */
	public function deactivateThirdPartyPlugin($I, $name)
	{
		// Login as the Administrator.
		$I->loginAsAdmin();

		// Go to the Plugins screen in the WordPress Administration interface.
		$I->amOnPluginsPage();

		// Deactivate the Plugin.
		$I->deactivatePlugin($name);

		// Check that the Plugin deactivated successfully.
		$I->seePluginDeactivated($name);

		// Check that no PHP warnings or notices were output.
		$I->checkNoWarningsAndNoticesOnScreen($I);
	}
}
