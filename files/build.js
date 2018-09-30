// load common layouts from local directory(NOTE: must be run AFTER including jquery)
$("#footer").load("footer.html");
$("#drawer").load("drawer.html");
$("#top-bar").load("top-bar.html");

// initialize components
$(function(){
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
    for (var i = 0; i < document.querySelectorAll('.material-icons').length; i++) {
        var btn = document.querySelectorAll('.material-icons')[i];
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
    }

});
