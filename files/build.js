// initialize components(NOTE: must be run AFTER including jquery)
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

$(function(){
    async function load() {
        try {
            // load common layouts from local directory
            await $("#footer").load("footer.html?v=1.6");
            await $("#drawer").load("drawer.html?v=1.6");
            await $("#top-bar").load("top-bar.html?v=1.6");

            await sleep(100);

            // attach a ripple to each button
            for (var i = 0; i < document.querySelectorAll('.mat-button').length; i++) {
                var btn = document.querySelectorAll('.mat-button')[i];
                var rip = new mdc.ripple.MDCRipple(btn);
            }
            // attach a ripple to each drawer item
            for (var i = 0; i < document.querySelectorAll('.drawer-link').length; i++) {
                var btn = document.querySelectorAll('.drawer-link')[i];
                var rip = new mdc.ripple.MDCRipple(btn);
            }
            // attach a ripple to each material icon
            for (var i = 0; i < document.querySelectorAll('.mdc-top-app-bar__action-item').length; i++) {
                var btn = document.querySelectorAll('.mdc-top-app-bar__action-item')[i];
                var rip = new mdc.ripple.MDCRipple(btn);
                rip.unbounded=true;
            }

            for (var i = 0; i < document.querySelectorAll('.mdc-drawer__header-content').length; i++) {
                var btn = document.querySelectorAll('.mdc-drawer__header-content')[i];
                var rip = new mdc.ripple.MDCRipple(btn);
                // rip.unbounded=true;
            }
            for (var i = 0; i < document.querySelectorAll('.an-card').length; i++) {
                var btn = document.querySelectorAll('.an-card')[i];
                var rip = new mdc.ripple.MDCRipple(btn);
                // rip.unbounded=true;
            }

            // const checkbox = new mdc.checkbox.MDCCheckbox(document.querySelector('.mdc-checkbox'));
            // const formField = new mdc.formField.MDCFormField(document.querySelector('.mdc-form-field'));
            // formField.input = checkbox;

            // instantiate all text fields
            for (var i = 0; i < document.querySelectorAll('.mdc-text-field').length; i++) {
                var tf = document.querySelectorAll('.mdc-text-field')[i];
                var txt = new mdc.textField.MDCTextField(tf);
            }

            // and text field icons
            for (var i = 0; i < document.querySelectorAll('.mdc-text-field__icon').length; i++) {
                var icon = new mdc.textField.MDCTextFieldIcon(document.querySelectorAll('.mdc-text-field__icon')[i]);
            }

            const topAppBarElement = document.querySelector('.mdc-top-app-bar');
            // new mdc.drawer.MDCTemporaryDrawer(document.querySelector('.mdc-drawer--temporary'));
            let drawer = mdc.drawer.MDCTemporaryDrawer.attachTo(document.querySelector('.mdc-drawer'));
            $('#menu-icon')[0].addEventListener('click', function(){
                drawer.open = true;
            });

            // const tabBar = new mdc.tabs.MDCTabBar(document.querySelector('.mdc-tab-bar'));
            // for (var i = 0; i < document.querySelectorAll('.mdc-tab').length; i++) {
            //     mdc.tabs.MDCTab.attachTo(document.querySelectorAll('.mdc-tab')[i]);
            // }
            // for (var i = 0; i < document.querySelectorAll('.mdc-tab-indicator').length; i++) {
            //     mdc.tabs.MDCTabIndicator.attachTo(document.querySelectorAll('.mdc-tab-indicator')[i]);
            // }
            // mdc.tabs.MDCTabBarScroller.attachTo(document.querySelector('.mdc-tab-scroller'));


            // function to get filename from a path
            function get_filename(s){
                return s.substring(s.lastIndexOf('/')+1);
            }

            // find link of current page in drawer and highlight it
            for(var i = 0; i < $('.drawer-link').length; i++){
                var link = $('.drawer-link')[i];
                // if(link == null) continue;
                if(get_filename(link.href) == get_filename(window.location.pathname)){
                    link.classList.add('mdc-list-item-active');
                }
                // path '/' == path 'index.html'
                if(get_filename(link.href) == 'index.html'){
                    if(get_filename(window.location.pathname) == ''){
                        link.classList.add('mdc-list-item-active');
                    }
                }
            }
        } catch (e) {
            alert("載入頁面時發生問題。若發現任何 bug 請重整網頁，或按右上角的 '<>' 按鈕 -> issues 進行回報。");
            // location.reload();
            throw e;
        }
    }
    load();
});
