"use strict";

/*
 * Copyright (C) MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nikolay Beketov, 12 2019
 *
 */

/* global globalRootUrl, globalTranslate, Form, SemanticLocalization, PbxApi */
var automaticBackup = {
  $timeStart: $('#time-start'),
  $everySelect: $('#every'),
  $enableTgl: $('#enable-disable-toggle'),
  $sftpTgl: $('#sftp-toggle'),
  $ftpPort: $('#ftp_port'),
  $formObj: $('#backup-automatic-form'),
  $createNowTgl: $('#create-now'),
  validateRules: {
    ftp_host: {
      identifier: 'ftp_host',
      rules: [{
        type: 'empty',
        prompt: globalTranslate.bkp_ValidateHostEmpty
      }]
    },
    ftp_port: {
      identifier: 'ftp_port',
      rules: [{
        type: 'integer[0..65535]',
        prompt: globalTranslate.bkp_ValidatePortEmpty
      }]
    },
    at_time: {
      identifier: 'at_time',
      rules: [{
        type: 'empty',
        prompt: globalTranslate.bkp_ValidateTimeEmpty
      }]
    },
    keep_older_versions: {
      identifier: 'keep_older_versions',
      rules: [{
        type: 'integer[1..99]',
        prompt: globalTranslate.bkp_ValidateKeepVersionsEmpty
      }]
    }
  },
  initialize: function () {
    function initialize() {
      automaticBackup.$everySelect.dropdown();
      automaticBackup.$timeStart.calendar({
        firstDayOfWeek: SemanticLocalization.calendarFirstDayOfWeek,
        text: SemanticLocalization.calendarText,
        type: 'time',
        disableMinute: false,
        ampm: false
      });
      automaticBackup.$enableTgl.checkbox({
        onChange: automaticBackup.onEnableToggleChange,
        fireOnInit: true
      });
      automaticBackup.$sftpTgl.checkbox({
        onChange: automaticBackup.onSftpToggleChange
      });
      automaticBackup.initializeForm();
    }

    return initialize;
  }(),
  onEnableToggleChange: function () {
    function onEnableToggleChange() {
      if (automaticBackup.$enableTgl.checkbox('is unchecked')) {
        $('.disability').addClass('disabled');
      } else {
        $('.disability').removeClass('disabled');
      }
    }

    return onEnableToggleChange;
  }(),
  onSftpToggleChange: function () {
    function onSftpToggleChange() {
      if (automaticBackup.$sftpTgl.checkbox('is checked')) {
        automaticBackup.$ftpPort.val('22');
      } else {
        automaticBackup.$ftpPort.val('21');
      }
    }

    return onSftpToggleChange;
  }(),
  cbBeforeSendForm: function () {
    function cbBeforeSendForm(settings) {
      var result = settings;
      result.data = automaticBackup.$formObj.form('get values');
      return result;
    }

    return cbBeforeSendForm;
  }(),
  cbAfterSendForm: function () {
    function cbAfterSendForm() {
      if (automaticBackup.$createNowTgl.checkbox('is checked')) {
        PbxApi.BackupStartScheduled(automaticBackup.cbAfterStartScheduled);
      }
    }

    return cbAfterSendForm;
  }(),
  cbAfterStartScheduled: function () {
    function cbAfterStartScheduled(result) {
      if (result) {
        window.location = "".concat(globalRootUrl, "backup/index");
      }
    }

    return cbAfterStartScheduled;
  }(),
  initializeForm: function () {
    function initializeForm() {
      Form.$formObj = automaticBackup.$formObj;
      Form.url = "".concat(globalRootUrl, "backup/save");
      Form.validateRules = automaticBackup.validateRules;
      Form.cbBeforeSendForm = automaticBackup.cbBeforeSendForm;
      Form.cbAfterSendForm = automaticBackup.cbAfterSendForm;
      Form.initialize();
    }

    return initializeForm;
  }()
};
$(document).ready(function () {
  automaticBackup.initialize();
});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uL3NyYy9CYWNrdXAvYmFja3VwLWF1dG9tYXRpYy5qcyJdLCJuYW1lcyI6WyJhdXRvbWF0aWNCYWNrdXAiLCIkdGltZVN0YXJ0IiwiJCIsIiRldmVyeVNlbGVjdCIsIiRlbmFibGVUZ2wiLCIkc2Z0cFRnbCIsIiRmdHBQb3J0IiwiJGZvcm1PYmoiLCIkY3JlYXRlTm93VGdsIiwidmFsaWRhdGVSdWxlcyIsImZ0cF9ob3N0IiwiaWRlbnRpZmllciIsInJ1bGVzIiwidHlwZSIsInByb21wdCIsImdsb2JhbFRyYW5zbGF0ZSIsImJrcF9WYWxpZGF0ZUhvc3RFbXB0eSIsImZ0cF9wb3J0IiwiYmtwX1ZhbGlkYXRlUG9ydEVtcHR5IiwiYXRfdGltZSIsImJrcF9WYWxpZGF0ZVRpbWVFbXB0eSIsImtlZXBfb2xkZXJfdmVyc2lvbnMiLCJia3BfVmFsaWRhdGVLZWVwVmVyc2lvbnNFbXB0eSIsImluaXRpYWxpemUiLCJkcm9wZG93biIsImNhbGVuZGFyIiwiZmlyc3REYXlPZldlZWsiLCJTZW1hbnRpY0xvY2FsaXphdGlvbiIsImNhbGVuZGFyRmlyc3REYXlPZldlZWsiLCJ0ZXh0IiwiY2FsZW5kYXJUZXh0IiwiZGlzYWJsZU1pbnV0ZSIsImFtcG0iLCJjaGVja2JveCIsIm9uQ2hhbmdlIiwib25FbmFibGVUb2dnbGVDaGFuZ2UiLCJmaXJlT25Jbml0Iiwib25TZnRwVG9nZ2xlQ2hhbmdlIiwiaW5pdGlhbGl6ZUZvcm0iLCJhZGRDbGFzcyIsInJlbW92ZUNsYXNzIiwidmFsIiwiY2JCZWZvcmVTZW5kRm9ybSIsInNldHRpbmdzIiwicmVzdWx0IiwiZGF0YSIsImZvcm0iLCJjYkFmdGVyU2VuZEZvcm0iLCJQYnhBcGkiLCJCYWNrdXBTdGFydFNjaGVkdWxlZCIsImNiQWZ0ZXJTdGFydFNjaGVkdWxlZCIsIndpbmRvdyIsImxvY2F0aW9uIiwiZ2xvYmFsUm9vdFVybCIsIkZvcm0iLCJ1cmwiLCJkb2N1bWVudCIsInJlYWR5Il0sIm1hcHBpbmdzIjoiOztBQUFB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QUFDQStDLE1BQUFBLElBQUksQ0FBQ0MsR0FBTCxhQUFjRixhQUFkO0FBQ0FDLE1BQUFBLElBQUksQ0FBQzdDLGFBQUwsR0FBcUJULGVBQWUsQ0FBQ1MsYUFBckM7QUFDQTZDLE1BQUFBLElBQUksQ0FBQ1osZ0JBQUwsR0FBd0IxQyxlQUFlLENBQUMwQyxnQkFBeEM7QUFDQVksTUFBQUEsSUFBSSxDQUFDUCxlQUFMLEdBQXVCL0MsZUFBZSxDQUFDK0MsZUFBdkM7QUFDQU8sTUFBQUEsSUFBSSxDQUFDL0IsVUFBTDtBQUNBOztBQXBHc0I7QUFBQTtBQUFBLENBQXhCO0FBdUdBckIsQ0FBQyxDQUFDc0QsUUFBRCxDQUFELENBQVlDLEtBQVosQ0FBa0IsWUFBTTtBQUN2QnpELEVBQUFBLGVBQWUsQ0FBQ3VCLFVBQWhCO0FBQ0EsQ0FGRCIsInNvdXJjZXNDb250ZW50IjpbIi8qXG4gKiBDb3B5cmlnaHQgKEMpIE1JS08gTExDIC0gQWxsIFJpZ2h0cyBSZXNlcnZlZFxuICogVW5hdXRob3JpemVkIGNvcHlpbmcgb2YgdGhpcyBmaWxlLCB2aWEgYW55IG1lZGl1bSBpcyBzdHJpY3RseSBwcm9oaWJpdGVkXG4gKiBQcm9wcmlldGFyeSBhbmQgY29uZmlkZW50aWFsXG4gKiBXcml0dGVuIGJ5IE5pa29sYXkgQmVrZXRvdiwgMTIgMjAxOVxuICpcbiAqL1xuXG4vKiBnbG9iYWwgZ2xvYmFsUm9vdFVybCwgZ2xvYmFsVHJhbnNsYXRlLCBGb3JtLCBTZW1hbnRpY0xvY2FsaXphdGlvbiwgUGJ4QXBpICovXG5cbmNvbnN0IGF1dG9tYXRpY0JhY2t1cCA9IHtcblx0JHRpbWVTdGFydDogJCgnI3RpbWUtc3RhcnQnKSxcblx0JGV2ZXJ5U2VsZWN0OiAkKCcjZXZlcnknKSxcblx0JGVuYWJsZVRnbDogJCgnI2VuYWJsZS1kaXNhYmxlLXRvZ2dsZScpLFxuXHQkc2Z0cFRnbDogJCgnI3NmdHAtdG9nZ2xlJyksXG5cdCRmdHBQb3J0OiAkKCcjZnRwX3BvcnQnKSxcblx0JGZvcm1PYmo6ICQoJyNiYWNrdXAtYXV0b21hdGljLWZvcm0nKSxcblx0JGNyZWF0ZU5vd1RnbDogJCgnI2NyZWF0ZS1ub3cnKSxcblx0dmFsaWRhdGVSdWxlczoge1xuXHRcdGZ0cF9ob3N0OiB7XG5cdFx0XHRpZGVudGlmaWVyOiAnZnRwX2hvc3QnLFxuXHRcdFx0cnVsZXM6IFtcblx0XHRcdFx0e1xuXHRcdFx0XHRcdHR5cGU6ICdlbXB0eScsXG5cdFx0XHRcdFx0cHJvbXB0OiBnbG9iYWxUcmFuc2xhdGUuYmtwX1ZhbGlkYXRlSG9zdEVtcHR5LFxuXHRcdFx0XHR9LFxuXHRcdFx0XSxcblx0XHR9LFxuXHRcdGZ0cF9wb3J0OiB7XG5cdFx0XHRpZGVudGlmaWVyOiAnZnRwX3BvcnQnLFxuXHRcdFx0cnVsZXM6IFtcblx0XHRcdFx0e1xuXHRcdFx0XHRcdHR5cGU6ICdpbnRlZ2VyWzAuLjY1NTM1XScsXG5cdFx0XHRcdFx0cHJvbXB0OiBnbG9iYWxUcmFuc2xhdGUuYmtwX1ZhbGlkYXRlUG9ydEVtcHR5LFxuXHRcdFx0XHR9LFxuXHRcdFx0XSxcblx0XHR9LFxuXHRcdGF0X3RpbWU6IHtcblx0XHRcdGlkZW50aWZpZXI6ICdhdF90aW1lJyxcblx0XHRcdHJ1bGVzOiBbXG5cdFx0XHRcdHtcblx0XHRcdFx0XHR0eXBlOiAnZW1wdHknLFxuXHRcdFx0XHRcdHByb21wdDogZ2xvYmFsVHJhbnNsYXRlLmJrcF9WYWxpZGF0ZVRpbWVFbXB0eSxcblx0XHRcdFx0fSxcblx0XHRcdF0sXG5cdFx0fSxcblx0XHRrZWVwX29sZGVyX3ZlcnNpb25zOiB7XG5cdFx0XHRpZGVudGlmaWVyOiAna2VlcF9vbGRlcl92ZXJzaW9ucycsXG5cdFx0XHRydWxlczogW1xuXHRcdFx0XHR7XG5cdFx0XHRcdFx0dHlwZTogJ2ludGVnZXJbMS4uOTldJyxcblx0XHRcdFx0XHRwcm9tcHQ6IGdsb2JhbFRyYW5zbGF0ZS5ia3BfVmFsaWRhdGVLZWVwVmVyc2lvbnNFbXB0eSxcblx0XHRcdFx0fSxcblx0XHRcdF0sXG5cdFx0fSxcblx0fSxcblx0aW5pdGlhbGl6ZSgpIHtcblx0XHRhdXRvbWF0aWNCYWNrdXAuJGV2ZXJ5U2VsZWN0LmRyb3Bkb3duKCk7XG5cdFx0YXV0b21hdGljQmFja3VwLiR0aW1lU3RhcnQuY2FsZW5kYXIoe1xuXHRcdFx0Zmlyc3REYXlPZldlZWs6IFNlbWFudGljTG9jYWxpemF0aW9uLmNhbGVuZGFyRmlyc3REYXlPZldlZWssXG5cdFx0XHR0ZXh0OiBTZW1hbnRpY0xvY2FsaXphdGlvbi5jYWxlbmRhclRleHQsXG5cdFx0XHR0eXBlOiAndGltZScsXG5cdFx0XHRkaXNhYmxlTWludXRlOiBmYWxzZSxcblx0XHRcdGFtcG06IGZhbHNlLFxuXHRcdH0pO1xuXHRcdGF1dG9tYXRpY0JhY2t1cC4kZW5hYmxlVGdsLmNoZWNrYm94KHtcblx0XHRcdG9uQ2hhbmdlOiBhdXRvbWF0aWNCYWNrdXAub25FbmFibGVUb2dnbGVDaGFuZ2UsXG5cdFx0XHRmaXJlT25Jbml0OiB0cnVlLFxuXHRcdH0pO1xuXHRcdGF1dG9tYXRpY0JhY2t1cC4kc2Z0cFRnbC5jaGVja2JveCh7XG5cdFx0XHRvbkNoYW5nZTogYXV0b21hdGljQmFja3VwLm9uU2Z0cFRvZ2dsZUNoYW5nZSxcblx0XHR9KTtcblx0XHRhdXRvbWF0aWNCYWNrdXAuaW5pdGlhbGl6ZUZvcm0oKTtcblx0fSxcblx0b25FbmFibGVUb2dnbGVDaGFuZ2UoKSB7XG5cdFx0aWYgKGF1dG9tYXRpY0JhY2t1cC4kZW5hYmxlVGdsLmNoZWNrYm94KCdpcyB1bmNoZWNrZWQnKSkge1xuXHRcdFx0JCgnLmRpc2FiaWxpdHknKS5hZGRDbGFzcygnZGlzYWJsZWQnKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0JCgnLmRpc2FiaWxpdHknKS5yZW1vdmVDbGFzcygnZGlzYWJsZWQnKTtcblx0XHR9XG5cdH0sXG5cdG9uU2Z0cFRvZ2dsZUNoYW5nZSgpIHtcblx0XHRpZiAoYXV0b21hdGljQmFja3VwLiRzZnRwVGdsLmNoZWNrYm94KCdpcyBjaGVja2VkJykpIHtcblx0XHRcdGF1dG9tYXRpY0JhY2t1cC4kZnRwUG9ydC52YWwoJzIyJyk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdGF1dG9tYXRpY0JhY2t1cC4kZnRwUG9ydC52YWwoJzIxJyk7XG5cdFx0fVxuXHR9LFxuXHRjYkJlZm9yZVNlbmRGb3JtKHNldHRpbmdzKSB7XG5cdFx0Y29uc3QgcmVzdWx0ID0gc2V0dGluZ3M7XG5cdFx0cmVzdWx0LmRhdGEgPSBhdXRvbWF0aWNCYWNrdXAuJGZvcm1PYmouZm9ybSgnZ2V0IHZhbHVlcycpO1xuXHRcdHJldHVybiByZXN1bHQ7XG5cdH0sXG5cdGNiQWZ0ZXJTZW5kRm9ybSgpIHtcblx0XHRpZiAoYXV0b21hdGljQmFja3VwLiRjcmVhdGVOb3dUZ2wuY2hlY2tib3goJ2lzIGNoZWNrZWQnKSkge1xuXHRcdFx0UGJ4QXBpLkJhY2t1cFN0YXJ0U2NoZWR1bGVkKGF1dG9tYXRpY0JhY2t1cC5jYkFmdGVyU3RhcnRTY2hlZHVsZWQpO1xuXHRcdH1cblx0fSxcblx0Y2JBZnRlclN0YXJ0U2NoZWR1bGVkKHJlc3VsdCkge1xuXHRcdGlmIChyZXN1bHQpIHtcblx0XHRcdHdpbmRvdy5sb2NhdGlvbiA9IGAke2dsb2JhbFJvb3RVcmx9YmFja3VwL2luZGV4YDtcblx0XHR9XG5cdH0sXG5cdGluaXRpYWxpemVGb3JtKCkge1xuXHRcdEZvcm0uJGZvcm1PYmogPSBhdXRvbWF0aWNCYWNrdXAuJGZvcm1PYmo7XG5cdFx0Rm9ybS51cmwgPSBgJHtnbG9iYWxSb290VXJsfWJhY2t1cC9zYXZlYDtcblx0XHRGb3JtLnZhbGlkYXRlUnVsZXMgPSBhdXRvbWF0aWNCYWNrdXAudmFsaWRhdGVSdWxlcztcblx0XHRGb3JtLmNiQmVmb3JlU2VuZEZvcm0gPSBhdXRvbWF0aWNCYWNrdXAuY2JCZWZvcmVTZW5kRm9ybTtcblx0XHRGb3JtLmNiQWZ0ZXJTZW5kRm9ybSA9IGF1dG9tYXRpY0JhY2t1cC5jYkFmdGVyU2VuZEZvcm07XG5cdFx0Rm9ybS5pbml0aWFsaXplKCk7XG5cdH0sXG59O1xuXG4kKGRvY3VtZW50KS5yZWFkeSgoKSA9PiB7XG5cdGF1dG9tYXRpY0JhY2t1cC5pbml0aWFsaXplKCk7XG59KTtcblxuIl19