/**
 * @category   Ksolves
 * @package    Ksolves_LayeredNavigation
 * @author     Ksolves Team
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define([
    'jquery',
    'mage/storage',
    'Magento_Ui/js/modal/alert',
    'mage/apply/main',
    'mage/translate',
    'jquery/ui',

], function ($, storage, alert, mage) {

    /**
     * ksAjaxLayeredNavigationFilter Widget
     * call ajax on click event on view page
     */
    $.widget('mage.ksAjaxLayeredNavigationFilter', {

        /**
         * @return void
         */
        _create: function () {
            var self = this;
            /* find link element on page */
            var kslink = $(self.element.find('a'));

            /* call ajax on click event of each link*/
            kslink.each(function (index) {
                $(this).on('click',function(event){ 
                    event.preventDefault(); 
                    self.ksAjaxSubmit($(event.currentTarget).attr('href'));
                });
            });
        },

        /**
         * Replace the URL
         *
         * @param string url
         * @return void
         */
        ksReplaceUrl: function(submitUrl) {
            if (!submitUrl) {
                return;
            }

            if (typeof history.replaceState === 'function') {
                history.replaceState(null, null, submitUrl);
            }
        },

        /**
         * AJAX request
         *
         * @param string url
         * @return void
         */
        ksAjaxSubmit: function(submitUrl) {
            var self = this;
            var ksSidebarContainer  = $('.sidebar-main');
            var ksProductContainer  = $('.column.main');
            /* start page loading  */
            $('body').trigger('processStart');

            /* ajax call using knockout js ajax */
            return storage.post(submitUrl, true).done(
                function (response) {
                    self.ksReplaceUrl(submitUrl); 

                    /* update the content */
                    ksSidebarContainer.html(response.sidebar_main).trigger('contentUpdated');
                    ksProductContainer.html(response.products).trigger('contentUpdated');

                    /* stop page loading*/
                    $('body').trigger('processStop');
                }

            ).fail(
                function() {
                    /* alert msg on ajax fail */
                    alert({
                            content: ('Sorry, something went wrong. Please try again later.')
                        });
                    /* stop page loading */
                    $('body').trigger('processStop');
                }
            );

        }
    });
    return $.mage.ksAjaxLayeredNavigationFilter;
});
