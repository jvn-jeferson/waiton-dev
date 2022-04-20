<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* javascript/variables.twig */
class __TwigTemplate_cfa35984e365059349cf6d6f594a2362d5d6bc82815347cd43f16f3b50f3378f extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "var firstDayOfCalendar = '";
        echo twig_escape_filter($this->env, ($context["first_day_of_calendar"] ?? null), "js", null, true);
        echo "';
var themeImagePath = '";
        // line 3
        echo twig_escape_filter($this->env, ($context["theme_image_path"] ?? null), "js", null, true);
        echo "';
var mysqlDocTemplate = '";
        // line 4
        echo twig_escape_filter($this->env, PhpMyAdmin\Util::getMySQLDocuURL("%s"), "js", null, true);
        echo "';
var maxInputVars = ";
        // line 5
        echo twig_escape_filter($this->env, ($context["max_input_vars"] ?? null), "js", null, true);
        echo ";

";
        // line 7
        ob_start(function () { return ''; });
        // line 8
        // l10n: Month-year order for calendar, use either "calendar-month-year" or "calendar-year-month".
        echo _gettext("calendar-month-year");
        $context["show_month_after_year"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 10
        ob_start(function () { return ''; });
        // line 11
        // l10n: Year suffix for calendar, "none" is empty.
        echo _gettext("none");
        $context["year_suffix"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 14
        echo "if (\$.datepicker) {
  \$.datepicker.regional[''].closeText = '";
        // line 15
        ob_start(function () { return ''; });
        // l10n: Display text for calendar close link
        echo _gettext("Done");
        $___internal_85136e765204f15838be1c2383c461cb5c1a8740178aee647d6d036ab12aaa1b_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_85136e765204f15838be1c2383c461cb5c1a8740178aee647d6d036ab12aaa1b_, "js");
        echo "';
  \$.datepicker.regional[''].prevText = '";
        // line 16
        ob_start(function () { return ''; });
        // l10n: Previous month. Display text for previous month link in calendar
        echo _gettext("Prev");
        $___internal_5dffc09b75f3538d889653917b2df9dd80a787d7b1d81574183931d3e4a4bf0e_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_5dffc09b75f3538d889653917b2df9dd80a787d7b1d81574183931d3e4a4bf0e_, "js");
        echo "';
  \$.datepicker.regional[''].nextText = '";
        // line 17
        ob_start(function () { return ''; });
        // l10n: Next month. Display text for next month link in calendar
        echo _gettext("Next");
        $___internal_3c255d1828ce9d641e4c47e28c2f4ef68f771271e56a6287d7921e5a92ae9741_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_3c255d1828ce9d641e4c47e28c2f4ef68f771271e56a6287d7921e5a92ae9741_, "js");
        echo "';
  \$.datepicker.regional[''].currentText = '";
        // line 18
        ob_start(function () { return ''; });
        // l10n: Display text for current month link in calendar
        echo _gettext("Today");
        $___internal_0f83c5de82c0027d57ade96c8b2e6d0f4da6182bbec3f2755868dfeed9313273_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_0f83c5de82c0027d57ade96c8b2e6d0f4da6182bbec3f2755868dfeed9313273_, "js");
        echo "';
  \$.datepicker.regional[''].monthNames = [
    '";
        // line 20
        echo twig_escape_filter($this->env, _gettext("January"), "js", null, true);
        echo "',
    '";
        // line 21
        echo twig_escape_filter($this->env, _gettext("February"), "js", null, true);
        echo "',
    '";
        // line 22
        echo twig_escape_filter($this->env, _gettext("March"), "js", null, true);
        echo "',
    '";
        // line 23
        echo twig_escape_filter($this->env, _gettext("April"), "js", null, true);
        echo "',
    '";
        // line 24
        echo twig_escape_filter($this->env, _gettext("May"), "js", null, true);
        echo "',
    '";
        // line 25
        echo twig_escape_filter($this->env, _gettext("June"), "js", null, true);
        echo "',
    '";
        // line 26
        echo twig_escape_filter($this->env, _gettext("July"), "js", null, true);
        echo "',
    '";
        // line 27
        echo twig_escape_filter($this->env, _gettext("August"), "js", null, true);
        echo "',
    '";
        // line 28
        echo twig_escape_filter($this->env, _gettext("September"), "js", null, true);
        echo "',
    '";
        // line 29
        echo twig_escape_filter($this->env, _gettext("October"), "js", null, true);
        echo "',
    '";
        // line 30
        echo twig_escape_filter($this->env, _gettext("November"), "js", null, true);
        echo "',
    '";
        // line 31
        echo twig_escape_filter($this->env, _gettext("December"), "js", null, true);
        echo "',
  ];
  \$.datepicker.regional[''].monthNamesShort = [
    '";
        // line 34
        ob_start(function () { return ''; });
        // l10n: Short month name for January
        echo _gettext("Jan");
        $___internal_3ea1a2a9acc802351230bbe82ccf938ead950f9906664c0977184a67210e5075_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_3ea1a2a9acc802351230bbe82ccf938ead950f9906664c0977184a67210e5075_, "js");
        echo "',
    '";
        // line 35
        ob_start(function () { return ''; });
        // l10n: Short month name for February
        echo _gettext("Feb");
        $___internal_666d4a2fa84b271c05e1f912e1ed54f3ad97f2730482ee3bbdf6f465034c720c_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_666d4a2fa84b271c05e1f912e1ed54f3ad97f2730482ee3bbdf6f465034c720c_, "js");
        echo "',
    '";
        // line 36
        ob_start(function () { return ''; });
        // l10n: Short month name for March
        echo _gettext("Mar");
        $___internal_029ec4e8bc260f94e63b173f8935a1700cdd0f285f3482128361946deea8f0eb_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_029ec4e8bc260f94e63b173f8935a1700cdd0f285f3482128361946deea8f0eb_, "js");
        echo "',
    '";
        // line 37
        ob_start(function () { return ''; });
        // l10n: Short month name for April
        echo _gettext("Apr");
        $___internal_d060128d5eb5abce7417a93c638d5ac54a6dc9fc9c3977e7c0ba38ab4e216ea2_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_d060128d5eb5abce7417a93c638d5ac54a6dc9fc9c3977e7c0ba38ab4e216ea2_, "js");
        echo "',
    '";
        // line 38
        ob_start(function () { return ''; });
        // l10n: Short month name for May
        echo _gettext("May");
        $___internal_36d9c139505f76a53d64c8bad447696d0b6976193408f589923c5e74bf8d5f0b_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_36d9c139505f76a53d64c8bad447696d0b6976193408f589923c5e74bf8d5f0b_, "js");
        echo "',
    '";
        // line 39
        ob_start(function () { return ''; });
        // l10n: Short month name for June
        echo _gettext("Jun");
        $___internal_71c27c9561d36152fb35f12e3effff84c7f905f869fca0a40ce3006337a51590_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_71c27c9561d36152fb35f12e3effff84c7f905f869fca0a40ce3006337a51590_, "js");
        echo "',
    '";
        // line 40
        ob_start(function () { return ''; });
        // l10n: Short month name for July
        echo _gettext("Jul");
        $___internal_880dce34dce8cce06a706bbcd63d33e4b5330762d1d87ec755941319e1e0aa8a_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_880dce34dce8cce06a706bbcd63d33e4b5330762d1d87ec755941319e1e0aa8a_, "js");
        echo "',
    '";
        // line 41
        ob_start(function () { return ''; });
        // l10n: Short month name for August
        echo _gettext("Aug");
        $___internal_5668589bc6120c02063cb93a18fd2e3e6501d3dd75d08cc4c6db396678da42c9_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_5668589bc6120c02063cb93a18fd2e3e6501d3dd75d08cc4c6db396678da42c9_, "js");
        echo "',
    '";
        // line 42
        ob_start(function () { return ''; });
        // l10n: Short month name for September
        echo _gettext("Sep");
        $___internal_f2dc28ff7c43009a220166f99b171c336afbd40b61e51e23b57bbe846f7fd2a9_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_f2dc28ff7c43009a220166f99b171c336afbd40b61e51e23b57bbe846f7fd2a9_, "js");
        echo "',
    '";
        // line 43
        ob_start(function () { return ''; });
        // l10n: Short month name for October
        echo _gettext("Oct");
        $___internal_f52e7fdb85197eedcb0e14b336b9aa26f2df733b33095d88d7e0aace923389a2_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_f52e7fdb85197eedcb0e14b336b9aa26f2df733b33095d88d7e0aace923389a2_, "js");
        echo "',
    '";
        // line 44
        ob_start(function () { return ''; });
        // l10n: Short month name for November
        echo _gettext("Nov");
        $___internal_27ad5dff3833a50f3f2cb06bda85a02aff7444c13792772affd50848cd39ec28_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_27ad5dff3833a50f3f2cb06bda85a02aff7444c13792772affd50848cd39ec28_, "js");
        echo "',
    '";
        // line 45
        ob_start(function () { return ''; });
        // l10n: Short month name for December
        echo _gettext("Dec");
        $___internal_71419e74d2491bce11c68f2db20a9bc56b923c51219e7f2817a788589797b147_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_71419e74d2491bce11c68f2db20a9bc56b923c51219e7f2817a788589797b147_, "js");
        echo "',
  ];
  \$.datepicker.regional[''].dayNames = [
    '";
        // line 48
        echo twig_escape_filter($this->env, _gettext("Sunday"), "js", null, true);
        echo "',
    '";
        // line 49
        echo twig_escape_filter($this->env, _gettext("Monday"), "js", null, true);
        echo "',
    '";
        // line 50
        echo twig_escape_filter($this->env, _gettext("Tuesday"), "js", null, true);
        echo "',
    '";
        // line 51
        echo twig_escape_filter($this->env, _gettext("Wednesday"), "js", null, true);
        echo "',
    '";
        // line 52
        echo twig_escape_filter($this->env, _gettext("Thursday"), "js", null, true);
        echo "',
    '";
        // line 53
        echo twig_escape_filter($this->env, _gettext("Friday"), "js", null, true);
        echo "',
    '";
        // line 54
        echo twig_escape_filter($this->env, _gettext("Saturday"), "js", null, true);
        echo "',
  ];
  \$.datepicker.regional[''].dayNamesShort = [
    '";
        // line 57
        ob_start(function () { return ''; });
        // l10n: Short week day name for Sunday
        echo _gettext("Sun");
        $___internal_ba521f8a3f4892ca1fa12018d7c87c186f6e5c8ca1433b6d0f3311457d996455_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_ba521f8a3f4892ca1fa12018d7c87c186f6e5c8ca1433b6d0f3311457d996455_, "js");
        echo "',
    '";
        // line 58
        ob_start(function () { return ''; });
        // l10n: Short week day name for Monday
        echo _gettext("Mon");
        $___internal_b17c32988acc808c3d34070644e7aabdafbc8af3005d1dae409be34abb90bf6b_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_b17c32988acc808c3d34070644e7aabdafbc8af3005d1dae409be34abb90bf6b_, "js");
        echo "',
    '";
        // line 59
        ob_start(function () { return ''; });
        // l10n: Short week day name for Tuesday
        echo _gettext("Tue");
        $___internal_213126a08fe332c8781ccf29e90869477c60e33094e84806fe8d8cc578e74e1d_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_213126a08fe332c8781ccf29e90869477c60e33094e84806fe8d8cc578e74e1d_, "js");
        echo "',
    '";
        // line 60
        ob_start(function () { return ''; });
        // l10n: Short week day name for Wednesday
        echo _gettext("Wed");
        $___internal_c36062fe01ab8d0f3f457760f936fa963bb1082889e9cb9db5d766ecef8b4f34_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_c36062fe01ab8d0f3f457760f936fa963bb1082889e9cb9db5d766ecef8b4f34_, "js");
        echo "',
    '";
        // line 61
        ob_start(function () { return ''; });
        // l10n: Short week day name for Thursday
        echo _gettext("Thu");
        $___internal_eb5fc35531488d2fa8b267e1a0d8de47b6e72bbd78a246fc45fe4c2a84e0562f_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_eb5fc35531488d2fa8b267e1a0d8de47b6e72bbd78a246fc45fe4c2a84e0562f_, "js");
        echo "',
    '";
        // line 62
        ob_start(function () { return ''; });
        // l10n: Short week day name for Friday
        echo _gettext("Fri");
        $___internal_4757d78e22c1b091da675074793d2f4d07388ae1e0de04b6ff9011b948858b54_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_4757d78e22c1b091da675074793d2f4d07388ae1e0de04b6ff9011b948858b54_, "js");
        echo "',
    '";
        // line 63
        ob_start(function () { return ''; });
        // l10n: Short week day name for Saturday
        echo _gettext("Sat");
        $___internal_e3ffb024598902379973de1b39a26b3c566e188e59e1032f7572054be74ee478_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_e3ffb024598902379973de1b39a26b3c566e188e59e1032f7572054be74ee478_, "js");
        echo "',
  ];
  \$.datepicker.regional[''].dayNamesMin = [
    '";
        // line 66
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Sunday
        echo _gettext("Su");
        $___internal_28284811c52b01fcf3ebd498479bd0783a09cd065c3f362f5948f76f8e537297_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_28284811c52b01fcf3ebd498479bd0783a09cd065c3f362f5948f76f8e537297_, "js");
        echo "',
    '";
        // line 67
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Monday
        echo _gettext("Mo");
        $___internal_b3099ae8be59f63e9e46fb82fba9a135a84f4cee3b895c3f99bda5b713d34fbc_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_b3099ae8be59f63e9e46fb82fba9a135a84f4cee3b895c3f99bda5b713d34fbc_, "js");
        echo "',
    '";
        // line 68
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Tuesday
        echo _gettext("Tu");
        $___internal_a1c4b05a5292ea5fd37ae2034009d41911adc8bee2ed0dacc94bf4c7a4f09a80_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_a1c4b05a5292ea5fd37ae2034009d41911adc8bee2ed0dacc94bf4c7a4f09a80_, "js");
        echo "',
    '";
        // line 69
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Wednesday
        echo _gettext("We");
        $___internal_138c2b60566b90af2425fb6998a4785d218196fa05be58b08d9da860a77b2906_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_138c2b60566b90af2425fb6998a4785d218196fa05be58b08d9da860a77b2906_, "js");
        echo "',
    '";
        // line 70
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Thursday
        echo _gettext("Th");
        $___internal_cbaa9a53067f1df876d1beeb7d80f45cf5161908d974ab17498af9f629b98cdf_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_cbaa9a53067f1df876d1beeb7d80f45cf5161908d974ab17498af9f629b98cdf_, "js");
        echo "',
    '";
        // line 71
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Friday
        echo _gettext("Fr");
        $___internal_5246995e1b2ce810c3226c9105b6b947705a85449f54e7692200d80cd6813793_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_5246995e1b2ce810c3226c9105b6b947705a85449f54e7692200d80cd6813793_, "js");
        echo "',
    '";
        // line 72
        ob_start(function () { return ''; });
        // l10n: Minimal week day name for Saturday
        echo _gettext("Sa");
        $___internal_bb5dbdcb56b0a1cb7b8b7c8d1bae9eae1b8881e9b85812543ff6e1eea1f0a31b_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_bb5dbdcb56b0a1cb7b8b7c8d1bae9eae1b8881e9b85812543ff6e1eea1f0a31b_, "js");
        echo "',
  ];
  \$.datepicker.regional[''].weekHeader = '";
        // line 74
        ob_start(function () { return ''; });
        // l10n: Column header for week of the year in calendar
        echo _gettext("Wk");
        $___internal_29e5e7e4c8843eb73828274637997ecae10fa1a82e6d54236c611f5cd85648f6_ = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        echo twig_escape_filter($this->env, $___internal_29e5e7e4c8843eb73828274637997ecae10fa1a82e6d54236c611f5cd85648f6_, "js");
        echo "';
  \$.datepicker.regional[''].showMonthAfterYear = ";
        // line 75
        echo (((($context["show_month_after_year"] ?? null) == "calendar-year-month")) ? ("true") : ("false"));
        echo ";
  \$.datepicker.regional[''].yearSuffix = '";
        // line 76
        echo (((($context["year_suffix"] ?? null) != "none")) ? (twig_escape_filter($this->env, ($context["year_suffix"] ?? null), "js")) : (""));
        echo "';
  \$.extend(\$.datepicker._defaults, \$.datepicker.regional['']);
}

if (\$.timepicker) {
  \$.timepicker.regional[''].timeText = '";
        // line 81
        echo twig_escape_filter($this->env, _gettext("Time"), "js", null, true);
        echo "';
  \$.timepicker.regional[''].hourText = '";
        // line 82
        echo twig_escape_filter($this->env, _gettext("Hour"), "js", null, true);
        echo "';
  \$.timepicker.regional[''].minuteText = '";
        // line 83
        echo twig_escape_filter($this->env, _gettext("Minute"), "js", null, true);
        echo "';
  \$.timepicker.regional[''].secondText = '";
        // line 84
        echo twig_escape_filter($this->env, _gettext("Second"), "js", null, true);
        echo "';
  \$.extend(\$.timepicker._defaults, \$.timepicker.regional['']);
}

function extendingValidatorMessages () {
  \$.extend(\$.validator.messages, {
    required: '";
        // line 90
        echo twig_escape_filter($this->env, _gettext("This field is required"), "js", null, true);
        echo "',
    remote: '";
        // line 91
        echo twig_escape_filter($this->env, _gettext("Please fix this field"), "js", null, true);
        echo "',
    email: '";
        // line 92
        echo twig_escape_filter($this->env, _gettext("Please enter a valid email address"), "js", null, true);
        echo "',
    url: '";
        // line 93
        echo twig_escape_filter($this->env, _gettext("Please enter a valid URL"), "js", null, true);
        echo "',
    date: '";
        // line 94
        echo twig_escape_filter($this->env, _gettext("Please enter a valid date"), "js", null, true);
        echo "',
    dateISO: '";
        // line 95
        echo twig_escape_filter($this->env, _gettext("Please enter a valid date ( ISO )"), "js", null, true);
        echo "',
    number: '";
        // line 96
        echo twig_escape_filter($this->env, _gettext("Please enter a valid number"), "js", null, true);
        echo "',
    creditcard: '";
        // line 97
        echo twig_escape_filter($this->env, _gettext("Please enter a valid credit card number"), "js", null, true);
        echo "',
    digits: '";
        // line 98
        echo twig_escape_filter($this->env, _gettext("Please enter only digits"), "js", null, true);
        echo "',
    equalTo: '";
        // line 99
        echo twig_escape_filter($this->env, _gettext("Please enter the same value again"), "js", null, true);
        echo "',
    maxlength: \$.validator.format('";
        // line 100
        echo twig_escape_filter($this->env, _gettext("Please enter no more than {0} characters"), "js", null, true);
        echo "'),
    minlength: \$.validator.format('";
        // line 101
        echo twig_escape_filter($this->env, _gettext("Please enter at least {0} characters"), "js", null, true);
        echo "'),
    rangelength: \$.validator.format('";
        // line 102
        echo twig_escape_filter($this->env, _gettext("Please enter a value between {0} and {1} characters long"), "js", null, true);
        echo "'),
    range: \$.validator.format('";
        // line 103
        echo twig_escape_filter($this->env, _gettext("Please enter a value between {0} and {1}"), "js", null, true);
        echo "'),
    max: \$.validator.format('";
        // line 104
        echo twig_escape_filter($this->env, _gettext("Please enter a value less than or equal to {0}"), "js", null, true);
        echo "'),
    min: \$.validator.format('";
        // line 105
        echo twig_escape_filter($this->env, _gettext("Please enter a value greater than or equal to {0}"), "js", null, true);
        echo "'),
    validationFunctionForDateTime: \$.validator.format('";
        // line 106
        echo twig_escape_filter($this->env, _gettext("Please enter a valid date or time"), "js", null, true);
        echo "'),
    validationFunctionForHex: \$.validator.format('";
        // line 107
        echo twig_escape_filter($this->env, _gettext("Please enter a valid HEX input"), "js", null, true);
        echo "'),
    validationFunctionForFuns: \$.validator.format('";
        // line 108
        echo twig_escape_filter($this->env, _gettext("Error"), "js", null, true);
        echo "')
  });
}
";
    }

    public function getTemplateName()
    {
        return "javascript/variables.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  509 => 108,  505 => 107,  501 => 106,  497 => 105,  493 => 104,  489 => 103,  485 => 102,  481 => 101,  477 => 100,  473 => 99,  469 => 98,  465 => 97,  461 => 96,  457 => 95,  453 => 94,  449 => 93,  445 => 92,  441 => 91,  437 => 90,  428 => 84,  424 => 83,  420 => 82,  416 => 81,  408 => 76,  404 => 75,  396 => 74,  387 => 72,  379 => 71,  371 => 70,  363 => 69,  355 => 68,  347 => 67,  339 => 66,  329 => 63,  321 => 62,  313 => 61,  305 => 60,  297 => 59,  289 => 58,  281 => 57,  275 => 54,  271 => 53,  267 => 52,  263 => 51,  259 => 50,  255 => 49,  251 => 48,  241 => 45,  233 => 44,  225 => 43,  217 => 42,  209 => 41,  201 => 40,  193 => 39,  185 => 38,  177 => 37,  169 => 36,  161 => 35,  153 => 34,  147 => 31,  143 => 30,  139 => 29,  135 => 28,  131 => 27,  127 => 26,  123 => 25,  119 => 24,  115 => 23,  111 => 22,  107 => 21,  103 => 20,  94 => 18,  86 => 17,  78 => 16,  70 => 15,  67 => 14,  63 => 11,  61 => 10,  57 => 8,  55 => 7,  50 => 5,  46 => 4,  42 => 3,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "javascript/variables.twig", "C:\\xampp\\htdocs\\waiton-dev\\public\\phpmyadmin\\templates\\javascript\\variables.twig");
    }
}
