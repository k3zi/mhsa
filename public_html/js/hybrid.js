/*!
 * ForBetterWeb.com - Hybrid Pro Landing Page - Bootstrap Theme
 */

// HTML5 Placeholder
$(function() {
    $('input, textarea').placeholder();
});

// Sidebar menu by Forbetterweb.com

    // Closes the sidebar menu
$("#menu-close").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});

    // Opens the sidebar menu
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#sidebar-wrapper").toggleClass("active");
});

    // Scrolls to the selected menu item on the page
$(function() {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
});

    // Collapse the navbar on scroll
$(window).scroll(function() {
    if ($("#sidebar-wrapper").offset().top > 50){
        $("#sidebar-wrapper").removeClass("active");
    }
});

// Load WOW.js on non-touch devices
var isPhoneDevice = "ontouchstart" in document.documentElement;
$(document).ready(function() {
    if (isPhoneDevice) {
        //mobile
    } else {
        //desktop
        // Initialize WOW.js
        wow = new WOW({
            offset: 50
        })
        wow.init();
    }
});


/*When clicking on Full hide fail/success boxes */
$('#name').focus(function() {
    $('#success').html('');
});

// jqBootstrapValidation
// * A plugin for automating validation on Twitter Bootstrap formatted forms.
// *
// * v1.3.6
// *
// * License: MIT <http://opensource.org/licenses/mit-license.php> - see LICENSE file
// *
// * http://ReactiveRaven.github.com/jqBootstrapValidation/


(function( $ ){

    var createdElements = [];

    var defaults = {
        options: {
            prependExistingHelpBlock: false,
            sniffHtml: true, // sniff for 'required', 'maxlength', etc
            preventSubmit: true, // stop the form submit event from firing if validation fails
            submitError: false, // function called if there is an error when trying to submit
            submitSuccess: false, // function called just before a successful submit event is sent to the server
            semanticallyStrict: false, // set to true to tidy up generated HTML output
            autoAdd: {
                helpBlocks: true
            },
            filter: function () {
                // return $(this).is(":visible"); // only validate elements you can see
                return true; // validate everything
            }
        },
        methods: {
            init : function( options ) {

                var settings = $.extend(true, {}, defaults);

                settings.options = $.extend(true, settings.options, options);

                var $siblingElements = this;

                var uniqueForms = $.unique(
                    $siblingElements.map( function () {
                        return $(this).parents("form")[0];
                    }).toArray()
                );

                $(uniqueForms).bind("submit", function (e) {
                    var $form = $(this);
                    var warningsFound = 0;
                    var $inputs = $form.find("input,textarea,select").not("[type=submit],[type=image]").filter(settings.options.filter);
                    $inputs.trigger("submit.validation").trigger("validationLostFocus.validation");

                    $inputs.each(function (i, el) {
                        var $this = $(el),
                            $controlGroup = $this.parents(".form-group").first();
                        if (
                            $controlGroup.hasClass("warning")
                        ) {
                            $controlGroup.removeClass("warning").addClass("error");
                            warningsFound++;
                        }
                    });

                    $inputs.trigger("validationLostFocus.validation");

                    if (warningsFound) {
                        if (settings.options.preventSubmit) {
                            e.preventDefault();
                        }
                        $form.addClass("error");
                        if ($.isFunction(settings.options.submitError)) {
                            settings.options.submitError($form, e, $inputs.jqBootstrapValidation("collectErrors", true));
                        }
                    } else {
                        $form.removeClass("error");
                        if ($.isFunction(settings.options.submitSuccess)) {
                            settings.options.submitSuccess($form, e);
                        }
                    }
                });

                return this.each(function(){

                    // Get references to everything we're interested in
                    var $this = $(this),
                        $controlGroup = $this.parents(".form-group").first(),
                        $helpBlock = $controlGroup.find(".help-block").first(),
                        $form = $this.parents("form").first(),
                        validatorNames = [];

                    // create message container if not exists
                    if (!$helpBlock.length && settings.options.autoAdd && settings.options.autoAdd.helpBlocks) {
                        $helpBlock = $('<div class="help-block" />');
                        $controlGroup.find('.controls').append($helpBlock);
                        createdElements.push($helpBlock[0]);
                    }

                    // =============================================================
                    //                                     SNIFF HTML FOR VALIDATORS
                    // =============================================================

                    // *snort sniff snuffle*

                    if (settings.options.sniffHtml) {
                        var message = "";
                        // ---------------------------------------------------------
                        //                                                   PATTERN
                        // ---------------------------------------------------------
                        if ($this.attr("pattern") !== undefined) {
                            message = "Not in the expected format<!-- data-validation-pattern-message to override -->";
                            if ($this.data("validationPatternMessage")) {
                                message = $this.data("validationPatternMessage");
                            }
                            $this.data("validationPatternMessage", message);
                            $this.data("validationPatternRegex", $this.attr("pattern"));
                        }
                        // ---------------------------------------------------------
                        //                                                       MAX
                        // ---------------------------------------------------------
                        if ($this.attr("max") !== undefined || $this.attr("aria-valuemax") !== undefined) {
                            var max = ($this.attr("max") !== undefined ? $this.attr("max") : $this.attr("aria-valuemax"));
                            message = "Too high: Maximum of '" + max + "'<!-- data-validation-max-message to override -->";
                            if ($this.data("validationMaxMessage")) {
                                message = $this.data("validationMaxMessage");
                            }
                            $this.data("validationMaxMessage", message);
                            $this.data("validationMaxMax", max);
                        }
                        // ---------------------------------------------------------
                        //                                                       MIN
                        // ---------------------------------------------------------
                        if ($this.attr("min") !== undefined || $this.attr("aria-valuemin") !== undefined) {
                            var min = ($this.attr("min") !== undefined ? $this.attr("min") : $this.attr("aria-valuemin"));
                            message = "Too low: Minimum of '" + min + "'<!-- data-validation-min-message to override -->";
                            if ($this.data("validationMinMessage")) {
                                message = $this.data("validationMinMessage");
                            }
                            $this.data("validationMinMessage", message);
                            $this.data("validationMinMin", min);
                        }
                        // ---------------------------------------------------------
                        //                                                 MAXLENGTH
                        // ---------------------------------------------------------
                        if ($this.attr("maxlength") !== undefined) {
                            message = "Too long: Maximum of '" + $this.attr("maxlength") + "' characters<!-- data-validation-maxlength-message to override -->";
                            if ($this.data("validationMaxlengthMessage")) {
                                message = $this.data("validationMaxlengthMessage");
                            }
                            $this.data("validationMaxlengthMessage", message);
                            $this.data("validationMaxlengthMaxlength", $this.attr("maxlength"));
                        }
                        // ---------------------------------------------------------
                        //                                                 MINLENGTH
                        // ---------------------------------------------------------
                        if ($this.attr("minlength") !== undefined) {
                            message = "Too short: Minimum of '" + $this.attr("minlength") + "' characters<!-- data-validation-minlength-message to override -->";
                            if ($this.data("validationMinlengthMessage")) {
                                message = $this.data("validationMinlengthMessage");
                            }
                            $this.data("validationMinlengthMessage", message);
                            $this.data("validationMinlengthMinlength", $this.attr("minlength"));
                        }
                        // ---------------------------------------------------------
                        //                                                  REQUIRED
                        // ---------------------------------------------------------
                        if ($this.attr("required") !== undefined || $this.attr("aria-required") !== undefined) {
                            message = settings.builtInValidators.required.message;
                            if ($this.data("validationRequiredMessage")) {
                                message = $this.data("validationRequiredMessage");
                            }
                            $this.data("validationRequiredMessage", message);
                        }
                        // ---------------------------------------------------------
                        //                                                    NUMBER
                        // ---------------------------------------------------------
                        if ($this.attr("type") !== undefined && $this.attr("type").toLowerCase() === "number") {
                            message = settings.builtInValidators.number.message;
                            if ($this.data("validationNumberMessage")) {
                                message = $this.data("validationNumberMessage");
                            }
                            $this.data("validationNumberMessage", message);
                        }
                        // ---------------------------------------------------------
                        //                                                     EMAIL
                        // ---------------------------------------------------------
                        if ($this.attr("type") !== undefined && $this.attr("type").toLowerCase() === "email") {
                            message = "Not a valid email address<!-- data-validator-validemail-message to override -->";
                            if ($this.data("validationValidemailMessage")) {
                                message = $this.data("validationValidemailMessage");
                            } else if ($this.data("validationEmailMessage")) {
                                message = $this.data("validationEmailMessage");
                            }
                            $this.data("validationValidemailMessage", message);
                        }
                        // ---------------------------------------------------------
                        //                                                MINCHECKED
                        // ---------------------------------------------------------
                        if ($this.attr("minchecked") !== undefined) {
                            message = "Not enough options checked; Minimum of '" + $this.attr("minchecked") + "' required<!-- data-validation-minchecked-message to override -->";
                            if ($this.data("validationMincheckedMessage")) {
                                message = $this.data("validationMincheckedMessage");
                            }
                            $this.data("validationMincheckedMessage", message);
                            $this.data("validationMincheckedMinchecked", $this.attr("minchecked"));
                        }
                        // ---------------------------------------------------------
                        //                                                MAXCHECKED
                        // ---------------------------------------------------------
                        if ($this.attr("maxchecked") !== undefined) {
                            message = "Too many options checked; Maximum of '" + $this.attr("maxchecked") + "' required<!-- data-validation-maxchecked-message to override -->";
                            if ($this.data("validationMaxcheckedMessage")) {
                                message = $this.data("validationMaxcheckedMessage");
                            }
                            $this.data("validationMaxcheckedMessage", message);
                            $this.data("validationMaxcheckedMaxchecked", $this.attr("maxchecked"));
                        }
                    }

                    // =============================================================
                    //                                       COLLECT VALIDATOR NAMES
                    // =============================================================

                    // Get named validators
                    if ($this.data("validation") !== undefined) {
                        validatorNames = $this.data("validation").split(",");
                    }

                    // Get extra ones defined on the element's data attributes
                    $.each($this.data(), function (i, el) {
                        var parts = i.replace(/([A-Z])/g, ",$1").split(",");
                        if (parts[0] === "validation" && parts[1]) {
                            validatorNames.push(parts[1]);
                        }
                    });

                    // =============================================================
                    //                                     NORMALISE VALIDATOR NAMES
                    // =============================================================

                    var validatorNamesToInspect = validatorNames;
                    var newValidatorNamesToInspect = [];

                    do // repeatedly expand 'shortcut' validators into their real validators
                    {
                        // Uppercase only the first letter of each name
                        $.each(validatorNames, function (i, el) {
                            validatorNames[i] = formatValidatorName(el);
                        });

                        // Remove duplicate validator names
                        validatorNames = $.unique(validatorNames);

                        // Pull out the new validator names from each shortcut
                        newValidatorNamesToInspect = [];
                        $.each(validatorNamesToInspect, function(i, el) {
                            if ($this.data("validation" + el + "Shortcut") !== undefined) {
                                // Are these custom validators?
                                // Pull them out!
                                $.each($this.data("validation" + el + "Shortcut").split(","), function(i2, el2) {
                                    newValidatorNamesToInspect.push(el2);
                                });
                            } else if (settings.builtInValidators[el.toLowerCase()]) {
                                // Is this a recognised built-in?
                                // Pull it out!
                                var validator = settings.builtInValidators[el.toLowerCase()];
                                if (validator.type.toLowerCase() === "shortcut") {
                                    $.each(validator.shortcut.split(","), function (i, el) {
                                        el = formatValidatorName(el);
                                        newValidatorNamesToInspect.push(el);
                                        validatorNames.push(el);
                                    });
                                }
                            }
                        });

                        validatorNamesToInspect = newValidatorNamesToInspect;

                    } while (validatorNamesToInspect.length > 0)

                    // =============================================================
                    //                                       SET UP VALIDATOR ARRAYS
                    // =============================================================

                    var validators = {};

                    $.each(validatorNames, function (i, el) {
                        // Set up the 'override' message
                        var message = $this.data("validation" + el + "Message");
                        var hasOverrideMessage = (message !== undefined);
                        var foundValidator = false;
                        message =
                            (
                                message
                                    ? message
                                    : "'" + el + "' validation failed <!-- Add attribute 'data-validation-" + el.toLowerCase() + "-message' to input to change this message -->"
                            )
                        ;

                        $.each(
                            settings.validatorTypes,
                            function (validatorType, validatorTemplate) {
                                if (validators[validatorType] === undefined) {
                                    validators[validatorType] = [];
                                }
                                if (!foundValidator && $this.data("validation" + el + formatValidatorName(validatorTemplate.name)) !== undefined) {
                                    validators[validatorType].push(
                                        $.extend(
                                            true,
                                            {
                                                name: formatValidatorName(validatorTemplate.name),
                                                message: message
                                            },
                                            validatorTemplate.init($this, el)
                                        )
                                    );
                                    foundValidator = true;
                                }
                            }
                        );

                        if (!foundValidator && settings.builtInValidators[el.toLowerCase()]) {

                            var validator = $.extend(true, {}, settings.builtInValidators[el.toLowerCase()]);
                            if (hasOverrideMessage) {
                                validator.message = message;
                            }
                            var validatorType = validator.type.toLowerCase();

                            if (validatorType === "shortcut") {
                                foundValidator = true;
                            } else {
                                $.each(
                                    settings.validatorTypes,
                                    function (validatorTemplateType, validatorTemplate) {
                                        if (validators[validatorTemplateType] === undefined) {
                                            validators[validatorTemplateType] = [];
                                        }
                                        if (!foundValidator && validatorType === validatorTemplateType.toLowerCase()) {
                                            $this.data("validation" + el + formatValidatorName(validatorTemplate.name), validator[validatorTemplate.name.toLowerCase()]);
                                            validators[validatorType].push(
                                                $.extend(
                                                    validator,
                                                    validatorTemplate.init($this, el)
                                                )
                                            );
                                            foundValidator = true;
                                        }
                                    }
                                );
                            }
                        }

                        if (! foundValidator) {
                            $.error("Cannot find validation info for '" + el + "'");
                        }
                    });

                    // =============================================================
                    //                                         STORE FALLBACK VALUES
                    // =============================================================

                    $helpBlock.data(
                        "original-contents",
                        (
                            $helpBlock.data("original-contents")
                                ? $helpBlock.data("original-contents")
                                : $helpBlock.html()
                        )
                    );

                    $helpBlock.data(
                        "original-role",
                        (
                            $helpBlock.data("original-role")
                                ? $helpBlock.data("original-role")
                                : $helpBlock.attr("role")
                        )
                    );

                    $controlGroup.data(
                        "original-classes",
                        (
                            $controlGroup.data("original-clases")
                                ? $controlGroup.data("original-classes")
                                : $controlGroup.attr("class")
                        )
                    );

                    $this.data(
                        "original-aria-invalid",
                        (
                            $this.data("original-aria-invalid")
                                ? $this.data("original-aria-invalid")
                                : $this.attr("aria-invalid")
                        )
                    );

                    // =============================================================
                    //                                                    VALIDATION
                    // =============================================================

                    $this.bind(
                        "validation.validation",
                        function (event, params) {

                            var value = getValue($this);

                            // Get a list of the errors to apply
                            var errorsFound = [];

                            $.each(validators, function (validatorType, validatorTypeArray) {
                                if (value || value.length || (params && params.includeEmpty) || (!!settings.validatorTypes[validatorType].blockSubmit && params && !!params.submitting)) {
                                    $.each(validatorTypeArray, function (i, validator) {
                                        if (settings.validatorTypes[validatorType].validate($this, value, validator)) {
                                            errorsFound.push(validator.message);
                                        }
                                    });
                                }
                            });

                            return errorsFound;
                        }
                    );

                    $this.bind(
                        "getValidators.validation",
                        function () {
                            return validators;
                        }
                    );

                    // =============================================================
                    //                                             WATCH FOR CHANGES
                    // =============================================================
                    $this.bind(
                        "submit.validation",
                        function () {
                            return $this.triggerHandler("change.validation", {submitting: true});
                        }
                    );
                    $this.bind(
                        [
                            "keyup",
                            "focus",
                            "blur",
                            "click",
                            "keydown",
                            "keypress",
                            "change"
                        ].join(".validation ") + ".validation",
                        function (e, params) {

                            var value = getValue($this);

                            var errorsFound = [];

                            $controlGroup.find("input,textarea,select").each(function (i, el) {
                                var oldCount = errorsFound.length;
                                $.each($(el).triggerHandler("validation.validation", params), function (j, message) {
                                    errorsFound.push(message);
                                });
                                if (errorsFound.length > oldCount) {
                                    $(el).attr("aria-invalid", "true");
                                } else {
                                    var original = $this.data("original-aria-invalid");
                                    $(el).attr("aria-invalid", (original !== undefined ? original : false));
                                }
                            });

                            $form.find("input,select,textarea").not($this).not("[name=\"" + $this.attr("name") + "\"]").trigger("validationLostFocus.validation");

                            errorsFound = $.unique(errorsFound.sort());

                            // Were there any errors?
                            if (errorsFound.length) {
                                // Better flag it up as a warning.
                                $controlGroup.removeClass("success error").addClass("warning");

                                // How many errors did we find?
                                if (settings.options.semanticallyStrict && errorsFound.length === 1) {
                                    // Only one? Being strict? Just output it.
                                    $helpBlock.html(errorsFound[0] +
                                    ( settings.options.prependExistingHelpBlock ? $helpBlock.data("original-contents") : "" ));
                                } else {
                                    // Multiple? Being sloppy? Glue them together into an UL.
                                    $helpBlock.html("<ul role=\"alert\"><li>" + errorsFound.join("</li><li>") + "</li></ul>" +
                                    ( settings.options.prependExistingHelpBlock ? $helpBlock.data("original-contents") : "" ));
                                }
                            } else {
                                $controlGroup.removeClass("warning error success");
                                if (value.length > 0) {
                                    $controlGroup.addClass("success");
                                }
                                $helpBlock.html($helpBlock.data("original-contents"));
                            }

                            if (e.type === "blur") {
                                $controlGroup.removeClass("success");
                            }
                        }
                    );
                    $this.bind("validationLostFocus.validation", function () {
                        $controlGroup.removeClass("success");
                    });
                });
            },
            destroy : function( ) {

                return this.each(
                    function() {

                        var
                            $this = $(this),
                            $controlGroup = $this.parents(".form-group").first(),
                            $helpBlock = $controlGroup.find(".help-block").first();

                        // remove our events
                        $this.unbind('.validation'); // events are namespaced.
                        // reset help text
                        $helpBlock.html($helpBlock.data("original-contents"));
                        // reset classes
                        $controlGroup.attr("class", $controlGroup.data("original-classes"));
                        // reset aria
                        $this.attr("aria-invalid", $this.data("original-aria-invalid"));
                        // reset role
                        $helpBlock.attr("role", $this.data("original-role"));
                        // remove all elements we created
                        if (createdElements.indexOf($helpBlock[0]) > -1) {
                            $helpBlock.remove();
                        }

                    }
                );

            },
            collectErrors : function(includeEmpty) {

                var errorMessages = {};
                this.each(function (i, el) {
                    var $el = $(el);
                    var name = $el.attr("name");
                    var errors = $el.triggerHandler("validation.validation", {includeEmpty: true});
                    errorMessages[name] = $.extend(true, errors, errorMessages[name]);
                });

                $.each(errorMessages, function (i, el) {
                    if (el.length === 0) {
                        delete errorMessages[i];
                    }
                });

                return errorMessages;

            },
            hasErrors: function() {

                var errorMessages = [];

                this.each(function (i, el) {
                    errorMessages = errorMessages.concat(
                        $(el).triggerHandler("getValidators.validation") ? $(el).triggerHandler("validation.validation", {submitting: true}) : []
                    );
                });

                return (errorMessages.length > 0);
            },
            override : function (newDefaults) {
                defaults = $.extend(true, defaults, newDefaults);
            }
        },
        validatorTypes: {
            callback: {
                name: "callback",
                init: function ($this, name) {
                    return {
                        validatorName: name,
                        callback: $this.data("validation" + name + "Callback"),
                        lastValue: $this.val(),
                        lastValid: true,
                        lastFinished: true
                    };
                },
                validate: function ($this, value, validator) {
                    if (validator.lastValue === value && validator.lastFinished) {
                        return !validator.lastValid;
                    }

                    if (validator.lastFinished === true)
                    {
                        validator.lastValue = value;
                        validator.lastValid = true;
                        validator.lastFinished = false;

                        var rrjqbvValidator = validator;
                        var rrjqbvThis = $this;
                        executeFunctionByName(
                            validator.callback,
                            window,
                            $this,
                            value,
                            function (data) {
                                if (rrjqbvValidator.lastValue === data.value) {
                                    rrjqbvValidator.lastValid = data.valid;
                                    if (data.message) {
                                        rrjqbvValidator.message = data.message;
                                    }
                                    rrjqbvValidator.lastFinished = true;
                                    rrjqbvThis.data("validation" + rrjqbvValidator.validatorName + "Message", rrjqbvValidator.message);
                                    // Timeout is set to avoid problems with the events being considered 'already fired'
                                    setTimeout(function () {
                                        rrjqbvThis.trigger("change.validation");
                                    }, 1); // doesn't need a long timeout, just long enough for the event bubble to burst
                                }
                            }
                        );
                    }

                    return false;

                }
            },
            ajax: {
                name: "ajax",
                init: function ($this, name) {
                    return {
                        validatorName: name,
                        url: $this.data("validation" + name + "Ajax"),
                        lastValue: $this.val(),
                        lastValid: true,
                        lastFinished: true
                    };
                },
                validate: function ($this, value, validator) {
                    if (""+validator.lastValue === ""+value && validator.lastFinished === true) {
                        return validator.lastValid === false;
                    }

                    if (validator.lastFinished === true)
                    {
                        validator.lastValue = value;
                        validator.lastValid = true;
                        validator.lastFinished = false;
                        $.ajax({
                            url: validator.url,
                            data: "value=" + value + "&field=" + $this.attr("name"),
                            dataType: "json",
                            success: function (data) {
                                if (""+validator.lastValue === ""+data.value) {
                                    validator.lastValid = !!(data.valid);
                                    if (data.message) {
                                        validator.message = data.message;
                                    }
                                    validator.lastFinished = true;
                                    $this.data("validation" + validator.validatorName + "Message", validator.message);
                                    // Timeout is set to avoid problems with the events being considered 'already fired'
                                    setTimeout(function () {
                                        $this.trigger("change.validation");
                                    }, 1); // doesn't need a long timeout, just long enough for the event bubble to burst
                                }
                            },
                            failure: function () {
                                validator.lastValid = true;
                                validator.message = "ajax call failed";
                                validator.lastFinished = true;
                                $this.data("validation" + validator.validatorName + "Message", validator.message);
                                // Timeout is set to avoid problems with the events being considered 'already fired'
                                setTimeout(function () {
                                    $this.trigger("change.validation");
                                }, 1); // doesn't need a long timeout, just long enough for the event bubble to burst
                            }
                        });
                    }

                    return false;

                }
            },
            regex: {
                name: "regex",
                init: function ($this, name) {
                    return {regex: regexFromString($this.data("validation" + name + "Regex"))};
                },
                validate: function ($this, value, validator) {
                    return (!validator.regex.test(value) && ! validator.negative)
                        || (validator.regex.test(value) && validator.negative);
                }
            },
            required: {
                name: "required",
                init: function ($this, name) {
                    return {};
                },
                validate: function ($this, value, validator) {
                    return !!(value.length === 0  && ! validator.negative)
                        || !!(value.length > 0 && validator.negative);
                },
                blockSubmit: true
            },
            match: {
                name: "match",
                init: function ($this, name) {
                    var element = $this.parents("form").first().find("[name=\"" + $this.data("validation" + name + "Match") + "\"]").first();
                    element.bind("validation.validation", function () {
                        $this.trigger("change.validation", {submitting: true});
                    });
                    return {"element": element};
                },
                validate: function ($this, value, validator) {
                    return (value !== validator.element.val() && ! validator.negative)
                        || (value === validator.element.val() && validator.negative);
                },
                blockSubmit: true
            },
            max: {
                name: "max",
                init: function ($this, name) {
                    return {max: $this.data("validation" + name + "Max")};
                },
                validate: function ($this, value, validator) {
                    return (parseFloat(value, 10) > parseFloat(validator.max, 10) && ! validator.negative)
                        || (parseFloat(value, 10) <= parseFloat(validator.max, 10) && validator.negative);
                }
            },
            min: {
                name: "min",
                init: function ($this, name) {
                    return {min: $this.data("validation" + name + "Min")};
                },
                validate: function ($this, value, validator) {
                    return (parseFloat(value) < parseFloat(validator.min) && ! validator.negative)
                        || (parseFloat(value) >= parseFloat(validator.min) && validator.negative);
                }
            },
            maxlength: {
                name: "maxlength",
                init: function ($this, name) {
                    return {maxlength: $this.data("validation" + name + "Maxlength")};
                },
                validate: function ($this, value, validator) {
                    return ((value.length > validator.maxlength) && ! validator.negative)
                        || ((value.length <= validator.maxlength) && validator.negative);
                }
            },
            minlength: {
                name: "minlength",
                init: function ($this, name) {
                    return {minlength: $this.data("validation" + name + "Minlength")};
                },
                validate: function ($this, value, validator) {
                    return ((value.length < validator.minlength) && ! validator.negative)
                        || ((value.length >= validator.minlength) && validator.negative);
                }
            },
            maxchecked: {
                name: "maxchecked",
                init: function ($this, name) {
                    var elements = $this.parents("form").first().find("[name=\"" + $this.attr("name") + "\"]");
                    elements.bind("click.validation", function () {
                        $this.trigger("change.validation", {includeEmpty: true});
                    });
                    return {maxchecked: $this.data("validation" + name + "Maxchecked"), elements: elements};
                },
                validate: function ($this, value, validator) {
                    return (validator.elements.filter(":checked").length > validator.maxchecked && ! validator.negative)
                        || (validator.elements.filter(":checked").length <= validator.maxchecked && validator.negative);
                },
                blockSubmit: true
            },
            minchecked: {
                name: "minchecked",
                init: function ($this, name) {
                    var elements = $this.parents("form").first().find("[name=\"" + $this.attr("name") + "\"]");
                    elements.bind("click.validation", function () {
                        $this.trigger("change.validation", {includeEmpty: true});
                    });
                    return {minchecked: $this.data("validation" + name + "Minchecked"), elements: elements};
                },
                validate: function ($this, value, validator) {
                    return (validator.elements.filter(":checked").length < validator.minchecked && ! validator.negative)
                        || (validator.elements.filter(":checked").length >= validator.minchecked && validator.negative);
                },
                blockSubmit: true
            }
        },
        builtInValidators: {
            email: {
                name: "Email",
                type: "shortcut",
                shortcut: "validemail"
            },
            validemail: {
                name: "Validemail",
                type: "regex",
                regex: "[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\\.[A-Za-z]{2,4}",
                message: "Not a valid email address<!-- data-validator-validemail-message to override -->"
            },
            passwordagain: {
                name: "Passwordagain",
                type: "match",
                match: "password",
                message: "Does not match the given password<!-- data-validator-paswordagain-message to override -->"
            },
            positive: {
                name: "Positive",
                type: "shortcut",
                shortcut: "number,positivenumber"
            },
            negative: {
                name: "Negative",
                type: "shortcut",
                shortcut: "number,negativenumber"
            },
            number: {
                name: "Number",
                type: "regex",
                regex: "([+-]?\\\d+(\\\.\\\d*)?([eE][+-]?[0-9]+)?)?",
                message: "Must be a number<!-- data-validator-number-message to override -->"
            },
            integer: {
                name: "Integer",
                type: "regex",
                regex: "[+-]?\\\d+",
                message: "No decimal places allowed<!-- data-validator-integer-message to override -->"
            },
            positivenumber: {
                name: "Positivenumber",
                type: "min",
                min: 0,
                message: "Must be a positive number<!-- data-validator-positivenumber-message to override -->"
            },
            negativenumber: {
                name: "Negativenumber",
                type: "max",
                max: 0,
                message: "Must be a negative number<!-- data-validator-negativenumber-message to override -->"
            },
            required: {
                name: "Required",
                type: "required",
                message: "This is required<!-- data-validator-required-message to override -->"
            },
            checkone: {
                name: "Checkone",
                type: "minchecked",
                minchecked: 1,
                message: "Check at least one option<!-- data-validation-checkone-message to override -->"
            }
        }
    };

    var formatValidatorName = function (name) {
        return name
            .toLowerCase()
            .replace(
            /(^|\s)([a-z])/g ,
            function(m,p1,p2) {
                return p1+p2.toUpperCase();
            }
        )
            ;
    };

    var getValue = function ($this) {
        // Extract the value we're talking about
        var value = $this.val();
        var type = $this.attr("type");
        if (type === "checkbox") {
            value = ($this.is(":checked") ? value : "");
        }
        if (type === "radio") {
            value = ($('input[name="' + $this.attr("name") + '"]:checked').length > 0 ? value : "");
        }
        return value;
    };

    function regexFromString(inputstring) {
        return new RegExp("^" + inputstring + "$");
    }

    /**
     * Thanks to Jason Bunting via StackOverflow.com
     *
     * http://stackoverflow.com/questions/359788/how-to-execute-a-javascript-function-when-i-have-its-name-as-a-string#answer-359910
     * Short link: http://tinyurl.com/executeFunctionByName
     **/
    function executeFunctionByName(functionName, context /*, args*/) {
        var args = Array.prototype.slice.call(arguments).splice(2);
        var namespaces = functionName.split(".");
        var func = namespaces.pop();
        for(var i = 0; i < namespaces.length; i++) {
            context = context[namespaces[i]];
        }
        return context[func].apply(this, args);
    }

    $.fn.jqBootstrapValidation = function( method ) {

        if ( defaults.methods[method] ) {
            return defaults.methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return defaults.methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.jqBootstrapValidation' );
            return null;
        }

    };

    $.jqBootstrapValidation = function (options) {
        $(":input").not("[type=image],[type=submit]").jqBootstrapValidation.apply(this,arguments);
    };

})( jQuery );

// Floating label headings for the contact form
$(function() {
    $("body").on("input propertychange", ".floating-label-form-group", function(e) {
        $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
    }).on("focus", ".floating-label-form-group", function() {
        $(this).addClass("floating-label-form-group-with-focus");
    }).on("blur", ".floating-label-form-group", function() {
        $(this).removeClass("floating-label-form-group-with-focus");
    });
});



// SmoothScroll for websites v1.2.1
// Licensed under the terms of the MIT license.

// People involved
//  - Balazs Galambosi (maintainer)
//  - Michael Herf     (Pulse Algorithm)

(function(){

// Scroll Variables (tweakable)
    var defaultOptions = {

        // Scrolling Core
        frameRate        : 150, // [Hz]
        animationTime    : 400, // [px]
        stepSize         : 120, // [px]

        // Pulse (less tweakable)
        // ratio of "tail" to "acceleration"
        pulseAlgorithm   : true,
        pulseScale       : 8,
        pulseNormalize   : 1,

        // Acceleration
        accelerationDelta : 20,  // 20
        accelerationMax   : 1,   // 1

        // Keyboard Settings
        keyboardSupport   : true,  // option
        arrowScroll       : 50,     // [px]

        // Other
        touchpadSupport   : true,
        fixedBackground   : true,
        excluded          : ""
    };

    var options = defaultOptions;


// Other Variables
    var isExcluded = false;
    var isFrame = false;
    var direction = { x: 0, y: 0 };
    var initDone  = false;
    var root = document.documentElement;
    var activeElement;
    var observer;
    var deltaBuffer = [ 120, 120, 120 ];

    var key = { left: 37, up: 38, right: 39, down: 40, spacebar: 32,
        pageup: 33, pagedown: 34, end: 35, home: 36 };


    /***********************************************
     * SETTINGS
     ***********************************************/

    var options = defaultOptions;


    /***********************************************
     * INITIALIZE
     ***********************************************/

    /**
     * Tests if smooth scrolling is allowed. Shuts down everything if not.
     */
    function initTest() {

        var disableKeyboard = false;

        // disable keyboard support if anything above requested it
        if (disableKeyboard) {
            removeEvent("keydown", keydown);
        }

        if (options.keyboardSupport && !disableKeyboard) {
            addEvent("keydown", keydown);
        }
    }

    /**
     * Sets up scrolls array, determines if frames are involved.
     */
    function init() {

        if (!document.body) return;

        var body = document.body;
        var html = document.documentElement;
        var windowHeight = window.innerHeight;
        var scrollHeight = body.scrollHeight;

        // check compat mode for root element
        root = (document.compatMode.indexOf('CSS') >= 0) ? html : body;
        activeElement = body;

        initTest();
        initDone = true;

        // Checks if this script is running in a frame
        if (top != self) {
            isFrame = true;
        }

        /**
         * This fixes a bug where the areas left and right to
         * the content does not trigger the onmousewheel event
         * on some pages. e.g.: html, body { height: 100% }
         */
        else if (scrollHeight > windowHeight &&
            (body.offsetHeight <= windowHeight ||
            html.offsetHeight <= windowHeight)) {

            // DOMChange (throttle): fix height
            var pending = false;
            var refresh = function () {
                if (!pending && html.scrollHeight != document.height) {
                    pending = true; // add a new pending action
                    setTimeout(function () {
                        html.style.height = document.height + 'px';
                        pending = false;
                    }, 500); // act rarely to stay fast
                }
            };
//            html.style.height = 'auto';
            setTimeout(refresh, 10);

            // clearfix
            if (root.offsetHeight <= windowHeight) {
                var underlay = document.createElement("div");
                underlay.style.clear = "both";
                body.appendChild(underlay);
            }
        }

        // disable fixed background
        if (!options.fixedBackground && !isExcluded) {
            body.style.backgroundAttachment = "scroll";
            html.style.backgroundAttachment = "scroll";
        }
    }


    /************************************************
     * SCROLLING
     ************************************************/

    var que = [];
    var pending = false;
    var lastScroll = +new Date;

    /**
     * Pushes scroll actions to the scrolling queue.
     */
    function scrollArray(elem, left, top, delay) {

        delay || (delay = 1000);
        directionCheck(left, top);

        if (options.accelerationMax != 1) {
            var now = +new Date;
            var elapsed = now - lastScroll;
            if (elapsed < options.accelerationDelta) {
                var factor = (1 + (30 / elapsed)) / 2;
                if (factor > 1) {
                    factor = Math.min(factor, options.accelerationMax);
                    left *= factor;
                    top  *= factor;
                }
            }
            lastScroll = +new Date;
        }

        // push a scroll command
        que.push({
            x: left,
            y: top,
            lastX: (left < 0) ? 0.99 : -0.99,
            lastY: (top  < 0) ? 0.99 : -0.99,
            start: +new Date
        });

        // don't act if there's a pending queue
        if (pending) {
            return;
        }

        var scrollWindow = (elem === document.body);

        var step = function (time) {

            var now = +new Date;
            var scrollX = 0;
            var scrollY = 0;

            for (var i = 0; i < que.length; i++) {

                var item = que[i];
                var elapsed  = now - item.start;
                var finished = (elapsed >= options.animationTime);

                // scroll position: [0, 1]
                var position = (finished) ? 1 : elapsed / options.animationTime;

                // easing [optional]
                if (options.pulseAlgorithm) {
                    position = pulse(position);
                }

                // only need the difference
                var x = (item.x * position - item.lastX) >> 0;
                var y = (item.y * position - item.lastY) >> 0;

                // add this to the total scrolling
                scrollX += x;
                scrollY += y;

                // update last values
                item.lastX += x;
                item.lastY += y;

                // delete and step back if it's over
                if (finished) {
                    que.splice(i, 1); i--;
                }
            }

            // scroll left and top
            if (scrollWindow) {
                window.scrollBy(scrollX, scrollY);
            }
            else {
                if (scrollX) elem.scrollLeft += scrollX;
                if (scrollY) elem.scrollTop  += scrollY;
            }

            // clean up if there's nothing left to do
            if (!left && !top) {
                que = [];
            }

            if (que.length) {
                requestFrame(step, elem, (delay / options.frameRate + 1));
            } else {
                pending = false;
            }
        };

        // start a new queue of actions
        requestFrame(step, elem, 0);
        pending = true;
    }


    /***********************************************
     * EVENTS
     ***********************************************/

    /**
     * Mouse wheel handler.
     * @param {Object} event
     */
    function wheel(event) {

        if (!initDone) {
            init();
        }

        var target = event.target;
        var overflowing = overflowingAncestor(target);

        // use default if there's no overflowing
        // element or default action is prevented
        if (!overflowing || event.defaultPrevented ||
            isNodeName(activeElement, "embed") ||
            (isNodeName(target, "embed") && /\.pdf/i.test(target.src))) {
            return true;
        }

        var deltaX = event.wheelDeltaX || 0;
        var deltaY = event.wheelDeltaY || 0;

        // use wheelDelta if deltaX/Y is not available
        if (!deltaX && !deltaY) {
            deltaY = event.wheelDelta || 0;
        }

        // check if it's a touchpad scroll that should be ignored
        if (!options.touchpadSupport && isTouchpad(deltaY)) {
            return true;
        }

        // scale by step size
        // delta is 120 most of the time
        // synaptics seems to send 1 sometimes
        if (Math.abs(deltaX) > 1.2) {
            deltaX *= options.stepSize / 120;
        }
        if (Math.abs(deltaY) > 1.2) {
            deltaY *= options.stepSize / 120;
        }

        scrollArray(overflowing, -deltaX, -deltaY);
        event.preventDefault();
    }

    /**
     * Keydown event handler.
     * @param {Object} event
     */
    function keydown(event) {

        var target   = event.target;
        var modifier = event.ctrlKey || event.altKey || event.metaKey ||
            (event.shiftKey && event.keyCode !== key.spacebar);

        // do nothing if user is editing text
        // or using a modifier key (except shift)
        // or in a dropdown
        if ( /input|textarea|select|embed/i.test(target.nodeName) ||
            target.isContentEditable ||
            event.defaultPrevented   ||
            modifier ) {
            return true;
        }
        // spacebar should trigger button press
        if (isNodeName(target, "button") &&
            event.keyCode === key.spacebar) {
            return true;
        }

        var shift, x = 0, y = 0;
        var elem = overflowingAncestor(activeElement);
        var clientHeight = elem.clientHeight;

        if (elem == document.body) {
            clientHeight = window.innerHeight;
        }

        switch (event.keyCode) {
            case key.up:
                y = -options.arrowScroll;
                break;
            case key.down:
                y = options.arrowScroll;
                break;
            case key.spacebar: // (+ shift)
                shift = event.shiftKey ? 1 : -1;
                y = -shift * clientHeight * 0.9;
                break;
            case key.pageup:
                y = -clientHeight * 0.9;
                break;
            case key.pagedown:
                y = clientHeight * 0.9;
                break;
            case key.home:
                y = -elem.scrollTop;
                break;
            case key.end:
                var damt = elem.scrollHeight - elem.scrollTop - clientHeight;
                y = (damt > 0) ? damt+10 : 0;
                break;
            case key.left:
                x = -options.arrowScroll;
                break;
            case key.right:
                x = options.arrowScroll;
                break;
            default:
                return true; // a key we don't care about
        }

        scrollArray(elem, x, y);
        event.preventDefault();
    }

    /**
     * Mousedown event only for updating activeElement
     */
    function mousedown(event) {
        activeElement = event.target;
    }


    /***********************************************
     * OVERFLOW
     ***********************************************/

    var cache = {}; // cleared out every once in while
    setInterval(function () { cache = {}; }, 10 * 1000);

    var uniqueID = (function () {
        var i = 0;
        return function (el) {
            return el.uniqueID || (el.uniqueID = i++);
        };
    })();

    function setCache(elems, overflowing) {
        for (var i = elems.length; i--;)
            cache[uniqueID(elems[i])] = overflowing;
        return overflowing;
    }

    function overflowingAncestor(el) {
        var elems = [];
        var rootScrollHeight = root.scrollHeight;
        do {
            var cached = cache[uniqueID(el)];
            if (cached) {
                return setCache(elems, cached);
            }
            elems.push(el);
            if (rootScrollHeight === el.scrollHeight) {
                if (!isFrame || root.clientHeight + 10 < rootScrollHeight) {
                    return setCache(elems, document.body); // scrolling root in WebKit
                }
            } else if (el.clientHeight + 10 < el.scrollHeight) {
                overflow = getComputedStyle(el, "").getPropertyValue("overflow-y");
                if (overflow === "scroll" || overflow === "auto") {
                    return setCache(elems, el);
                }
            }
        } while (el = el.parentNode);
    }


    /***********************************************
     * HELPERS
     ***********************************************/

    function addEvent(type, fn, bubble) {
        window.addEventListener(type, fn, (bubble||false));
    }

    function removeEvent(type, fn, bubble) {
        window.removeEventListener(type, fn, (bubble||false));
    }

    function isNodeName(el, tag) {
        return (el.nodeName||"").toLowerCase() === tag.toLowerCase();
    }

    function directionCheck(x, y) {
        x = (x > 0) ? 1 : -1;
        y = (y > 0) ? 1 : -1;
        if (direction.x !== x || direction.y !== y) {
            direction.x = x;
            direction.y = y;
            que = [];
            lastScroll = 0;
        }
    }

    var deltaBufferTimer;

    function isTouchpad(deltaY) {
        if (!deltaY) return;
        deltaY = Math.abs(deltaY)
        deltaBuffer.push(deltaY);
        deltaBuffer.shift();
        clearTimeout(deltaBufferTimer);
        var allDivisable = (isDivisible(deltaBuffer[0], 120) &&
        isDivisible(deltaBuffer[1], 120) &&
        isDivisible(deltaBuffer[2], 120));
        return !allDivisable;
    }

    function isDivisible(n, divisor) {
        return (Math.floor(n / divisor) == n / divisor);
    }

    var requestFrame = (function () {
        return  window.requestAnimationFrame       ||
            window.webkitRequestAnimationFrame ||
            function (callback, element, delay) {
                window.setTimeout(callback, delay || (1000/60));
            };
    })();


    /***********************************************
     * PULSE
     ***********************************************/

    /**
     * Viscous fluid with a pulse for part and decay for the rest.
     * - Applies a fixed force over an interval (a damped acceleration), and
     * - Lets the exponential bleed away the velocity over a longer interval
     * - Michael Herf, http://stereopsis.com/stopping/
     */
    function pulse_(x) {
        var val, start, expx;
        // test
        x = x * options.pulseScale;
        if (x < 1) { // acceleartion
            val = x - (1 - Math.exp(-x));
        } else {     // tail
            // the previous animation ended here:
            start = Math.exp(-1);
            // simple viscous drag
            x -= 1;
            expx = 1 - Math.exp(-x);
            val = start + (expx * (1 - start));
        }
        return val * options.pulseNormalize;
    }

    function pulse(x) {
        if (x >= 1) return 1;
        if (x <= 0) return 0;

        if (options.pulseNormalize == 1) {
            options.pulseNormalize /= pulse_(1);
        }
        return pulse_(x);
    }

    var isChrome = /chrome/i.test(window.navigator.userAgent);
    var wheelEvent = null;
    if ("onwheel" in document.createElement("div"))
        wheelEvent = "wheel";
    else if ("onmousewheel" in document.createElement("div"))
        wheelEvent = "mousewheel";

    if (wheelEvent && isChrome) {
        addEvent(wheelEvent, wheel);
        addEvent("mousedown", mousedown);
        addEvent("load", init);
    }

})();
