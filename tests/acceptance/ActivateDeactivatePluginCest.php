<?php
/**
 * Tests Plugin activation and deactivation.
 *
 * @since   3.8.4
 */
class ActivateDeactivatePluginCest
{
	/**
	 * Activate the Plugin and confirm a success notification
	 * is displayed with no errors.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function testPluginActivation(AcceptanceTester $I)
	{
		$I->activateWPToBufferPlugin($I);
	}

	/**
	 * Deactivate the Plugin and confirm a success notification
	 * is displayed with no errors.
	 *
	 * @since   1.4.0
	 *
	 * @param   AcceptanceTester $I  Tester.
	 */
	public function testPluginDeactivation(AcceptanceTester $I)
	{
		$I->deactivateWPToBufferPlugin($I);
	}
}
