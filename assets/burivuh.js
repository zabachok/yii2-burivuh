$.fn.extend({
    insertAtCaret: function (myValue) {
        return this.each(function (i) {
            if (document.selection) {
// Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
// Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + myValue + this.value.substring(endPos, this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});
burivuh = {
    write: {
        init: function () {
            this.saveInit();
            this.textFormatting.init();
            $("#burivuh-content").keypress(function (event) {
                return burivuh.write.newLine(event);
            });
            $("#burivuh-content").keydown(function (event) {
                burivuh.write.tab(event);
            });
        },
        saveInit: function () {
            $(window).bind('keydown', function (e) {
                if (e.ctrlKey || e.metaKey) {
                    var char = String.fromCharCode(e.which).toLowerCase();
                    if (char == 's' || char == 'ы') {
                        e.preventDefault();
                        $('#burivuh-save-butoon').click();
                    }
                }
            });
        },
        newLine: function (event) {
            if (event.shiftKey && event.keyCode == 13) {
                burivuh.write.setNewLine('#burivuh-content');
                return false;
            }
        },
        tab: function (event) {
            if (event.keyCode != 9)
                return;
            event.preventDefault();
            // Opera, FireFox, Chrome
            var
                obj = $("#burivuh-content")[0],
                start = obj.selectionStart,
                end = obj.selectionEnd,
                before = obj.value.substring(0, start),
                after = obj.value.substring(end, obj.value.length);
            obj.value = before + "    " + after;
            // устанавливаем курсор
            obj.setSelectionRange(start + 4, start + 4);
        },
        setNewLine: function (selector) {
            var id = $(selector);
            var val = id.val();
            var p = id[0].selectionStart;
            var length = val.length;
            while (true) {
                char = val.substr(p, 1);
                if (char == "\n") {
                    id[0].setSelectionRange(p, p);
                    id[0].focus();
                    id.insertAtCaret("\n");
                    break;
                }
                if (p == length - 1) {
                    p++;
                    id[0].setSelectionRange(p, p);
                    id[0].focus();
                    id.insertAtCaret("\n");
                    break;
                }
                p++;
                if (p >= length)
                    break;
            }
        },
        textFormatting: {

            init: function () {
                $("#burivuh-content").bind('keydown', function (e) {
                    if (e.ctrlKey || e.metaKey) {
                        var char = String.fromCharCode(e.which).toLowerCase();
                        if (char == 'h' || char == 'р') {
                            e.preventDefault();
                            burivuh.write.textFormatting.setHeader();
                        }
                    }
                });
            },

            setHeader: function () {
                var id = $("#burivuh-content");
                var val = id.val();
                var p = id[0].selectionStart;

                var parts = val.split("\n");

                var toStart = 0;
                for (var i = 0; i < parts.length; i++) {
                    var part = parts[i];
                    var start = toStart;
                    var end = toStart + part.length;

                    if (start <= p && p <= end) {
                        var newPart = part;

                        var match = part.match(/^(#*)( *)?/);

                        var sharpLength = match[1].length;
                        var oldLength = newPart.length;
                        var spaceLength = typeof match[2] == 'undefined' ? 0 : match[2].length;

                        newPart = newPart.substr(sharpLength + spaceLength);
                        if (sharpLength >= 6) sharpLength = 1;
                        else sharpLength++;
                        newPart = ' ' + newPart;
                        for (var s = 1; s <= sharpLength; s++) newPart = '#' + newPart;

                        id[0].setSelectionRange(start, end);
                        id[0].focus();
                        id.insertAtCaret(newPart);
                        var newLength = newPart.length;
                        var diff = newLength - oldLength;
                        id[0].setSelectionRange(p + diff, p + diff);
                        return;
                    }
                    toStart += part.length + 1;

                }
            },
            setBold: function () {
                this.textAttributes('**');
            },
            setItalic: function () {
                this.textAttributes('*');
            },
            setBoldItalic: function () {
                this.textAttributes('***');
            },
            textAttributes: function (string) {
                if (typeof string == 'undefined') string = '**';
                var length = string.length;

                var id = $("#burivuh-content");
                var val = id.val();
                var start = id[0].selectionStart;
                var end = id[0].selectionEnd;

                var prev = val.substr(start - length, length);
                var next = val.substr(end, length);
                if (prev == string && next == string) {
                    id[0].setSelectionRange(end, end + length);
                    id.insertAtCaret('');

                    id[0].setSelectionRange(start - length, start);
                    id.insertAtCaret('');

                    id[0].setSelectionRange(start - length, end - length);
                } else {
                    id[0].setSelectionRange(end, end);
                    id.insertAtCaret(string);

                    id[0].setSelectionRange(start, start);
                    id.insertAtCaret(string);

                    id[0].setSelectionRange(start + length, end + length);
                }
            },
            setLink: function () {
                $('#burivuh-picture-form').slideUp();
                var id = $("#burivuh-content");
                var val = id.val();
                var start = id[0].selectionStart;
                var end = id[0].selectionEnd;
                if (start != end) {
                    $('#burivuh-link-form').find('[name=label]').val(val.substr(start, end - start));
                } else {
                    $('#burivuh-link-form').find('[name=label]').val('');
                }
                $('#burivuh-link-form').slideToggle();

            },
            insertLink: function () {
                var id = $("#burivuh-content");
                var start = id[0].selectionStart;
                var end = id[0].selectionEnd;

                var text = '[' + $('#burivuh-link-form').find('[name=label]').val() +
                    '](' + $('#burivuh-link-form').find('[name=url]').val() + ')';
                id[0].setSelectionRange(start, end);
                id.insertAtCaret(text);
                $('#burivuh-link-form').find('[name=label]').val('');
                $('#burivuh-link-form').find('[name=url]').val('');
                $('#burivuh-link-form').slideUp();
            },
            insertPicture: function () {
                var id = $("#burivuh-content");
                var start = id[0].selectionStart;

                var text = '![' + $('#burivuh-picture-form').find('[name=alt]').val() +
                    '](' + $('#burivuh-picture-form').find('[name=url]').val() + ')';
                id[0].setSelectionRange(start, start);
                id.insertAtCaret(text);
                $('#burivuh-picture-form').find('[name=alt]').val('');
                $('#burivuh-picture-form').find('[name=url]').val('');
                $('#burivuh-picture-form').slideUp();
            }
        },
    },
    view: {
        init: function () {
            this.updateInit();
        },
        updateInit: function () {
            $(window).bind('keydown', function (e) {
                if (e.ctrlKey || e.metaKey) {
                    var char = String.fromCharCode(e.which).toLowerCase();
                    if (char == 'e' || char == 'у') {
                        e.preventDefault();
                        window.location.href = $('#burivuh-update-link').attr('href');
                    }
                }
            });
        }
    },
    index: {
        currentLine: 0,
        linesCount: 0,
        init: function () {
            this.linesCount = $('#burivuh-filelist tr').length;

            this.selectLine();
            this.hotKeysInit();
        },
        selectLine: function () {
            if (this.linesCout == 0) return;
            $('#burivuh-filelist tr').removeClass('success');
            $('#burivuh-filelist tr:eq(' + burivuh.index.currentLine + ')').addClass('success');

        },
        hotKeysInit: function () {

            $(window).bind('keydown', function (event) {
                switch (event.keyCode) {
                    case 38://up
                        if (burivuh.index.linesCout == 0) return;
                        if (burivuh.index.currentLine == 0) return;
                        event.preventDefault();
                        burivuh.index.currentLine--;
                        burivuh.index.selectLine();
                        break;
                    case 40://down
                        if (burivuh.index.linesCout == 0) return;
                        if (burivuh.index.currentLine + 1 == burivuh.index.linesCount) return;
                        event.preventDefault();
                        burivuh.index.currentLine++;
                        burivuh.index.selectLine();
                        break;
                    case 13://enter
                        if (burivuh.index.linesCout == 0) return;
                        event.preventDefault();
                        var href = $('#burivuh-filelist tr:eq(' + burivuh.index.currentLine + ')').find('.burivuh-line-link').attr('href');
                        if (typeof href == 'undefined') return;
                        window.location.href = href;
                        break;
                }
            });
        }
    }

}
