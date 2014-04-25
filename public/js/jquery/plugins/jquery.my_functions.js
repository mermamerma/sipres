/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}