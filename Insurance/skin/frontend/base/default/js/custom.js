var CustomCheckout = Class.create(Checkout, {
    initialize: function($super, accordion, urls){
        $super(accordion, urls);
        this.steps = ['login', 'billing', 'shipping', 'shipping_method', 'customstep', 'payment', 'review'];
    },

    setCustomStep: function() {
        this.gotoSection('customstep', true);
    }
});
var CustomStep = Class.create();
CustomStep.prototype = {
    initialize: function(form, saveUrl){
        this.form = form;

        if ($(this.form)) {
            $(this.form).observe('submit', function(event){this.save();Event.stop(event);}.bind(this));
        }

        this.saveUrl = saveUrl;
        this.validator = new Validation(this.form);
        this.onSave = this.nextStep.bindAsEventListener(this);
        this.onComplete = this.resetLoadWaiting.bindAsEventListener(this);
    },

    validate: function() {
        return this.validator.validate();
    },

    save: function(){
        if (checkout.loadWaiting != false) return;

        if (this.validate()) {
            checkout.setLoadWaiting('customstep');
            var request = new Ajax.Request(
                this.saveUrl,
                {
                    method:'post',
                    onComplete: this.onComplete,
                    onSuccess: this.onSave,
                    onFailure: checkout.ajaxFailure.bind(checkout),
                    parameters: Form.serialize(this.form)
                }
            );
        }
    },

    resetLoadWaiting: function(transport){
        checkout.setLoadWaiting(false);
    },

    nextStep: function(transport){
        var response = transport.responseJSON || transport.responseText.evalJSON(true) || {};

        if (response.error) {
            alert(response.message.stripTags().toString());
            return false;
        }

        if (response.update_section) {
            $('checkout-'+response.update_section.name+'-load').update(response.update_section.html);
        }

        if (response.goto_section) {
            checkout.gotoSection(response.goto_section, true);
            checkout.reloadProgressBlock();
            return;
        }

        checkout.setCustomStep();
    }
};