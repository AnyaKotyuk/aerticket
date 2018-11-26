$(document).ready(function () {
    $('form').submit(function(){
        let form = $(this);
        let data = {};
        data.searchQuery = form.serializeObject();

        $.ajax({
            method: form.attr('method'),
            url: 'http://api.aerticket.loc:8029?r=search',
            data: data,
            xhrFields: {
                withCredentials: true
            },
            username: 'aer',
            password: 'aer',
            success: function (res) {

                $(form).find('input + .error').html('');
                $('.empty').remove();
                $('table.results tr').not(':first-child').remove();

                if (res.errors) {
                    $(form).find('input').each(function(){
                        $(this).next('.error').text(res.errors[$(this).attr('name')]);
                    });

                } else {
                    let data = res.searchResults;

                    if(data) {

                        for (let i = 0; i < data.length; i++) {
                            let TR = '<tr>';
                            TR += '<td>'+data[i].transporter.code+'</td>';
                            TR += '<td>'+data[i].flightNumber+'</td>';
                            TR += '<td>'+data[i].departureDateTime+'</td>';
                            TR += '<td>'+data[i].arrivalDateTime+'</td>';
                            TR += '<td>'+data[i].duration+'</td>';
                            TR += '</tr>';

                            $('table.results').append(TR);
                        }
                        $('table.results').show();
                    } else {
                        $('table.results').hide();
                        $('<div class="empty">'+res+'</div>').insertAfter(form);
                    }
                }
            },
            error: function (res) {

                $(form).find('input + .error').html('');
                $('.empty').remove();
                $('table.results').hide();
                $('<div class="empty">'+res.responseText+'</div>').insertAfter(form);
            }
        });
        return false;
    });

});

$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
