let max = 2;
$(document).ready(function(){
  $('#penjualan').find('input[class$="select-dropdown dropdown-trigger"]').remove();
  $('#penjualan').find('svg[class$="caret"]').remove();
  $( ".datepicker" ).datepicker({
    format: 'yyyy-mm-dd'
  });
  $('.pencarian-barang select').formSelect();
  $('.carousel').carousel();
});

$( function() {
  $.widget( "custom.combobox", {
    _create: function() {
      this.wrapper = $( "<span>" )
        .addClass( "custom-combobox" )
        .insertAfter( this.element );

      this.element.hide();
      this._createAutocomplete();
      this._createShowAllButton();
    },

    _createAutocomplete: function() {
      var selected = this.element.children( ":selected" ),
        value = selected.val() ? selected.text() : "";

      this.input = $( "<input>" )
        .appendTo( this.wrapper )
        .val( value )
        .attr( "id", "id_barang" )
        .attr( "title", "" )
        .attr( "required", "" )
        .attr('type', 'text')
        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default f-dropdown" )
        .autocomplete({
          delay: 0,
          minLength: 0,
          source: $.proxy( this, "_source" )
        })
        .tooltip({
          classes: {
            "ui-tooltip": "ui-state-highlight"
          }
        });

      this._on( this.input, {
        autocompleteselect: function( event, ui ) {
          ui.item.option.selected = true;
          this._trigger( "select", event, {
            item: ui.item.option
          });
        },

        autocompletechange: "_removeIfInvalid"
      });
    },

    _createShowAllButton: function() {
      var input = this.input,
        wasOpen = false;

      $( "<a>" )
        .attr( "tabIndex", -1 )
        .tooltip()
        .appendTo( this.wrapper )
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "custom-combobox-toggle" )
        .on( "mousedown", function() {
          wasOpen = input.autocomplete( "widget" ).is( ":visible" );
        })
        .on( "click", function() {
          input.trigger( "focus" );

          // Close if already visible
          if ( wasOpen ) {
            return;
          }

          // Pass empty string as value to search for, displaying all results
          input.autocomplete( "search", "" );
        });
    },

    _source: function( request, response ) {
      var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
      response( this.element.children( "option" ).map(function() {
        var text = $( this ).text();
        if ( this.value && ( !request.term || matcher.test(text) ) )
          return {
            label: text,
            value: text,
            option: this
          };
      }) );
    },

    _removeIfInvalid: function( event, ui ) {

      // Selected an item, nothing to do
      if ( ui.item ) {
        return;
      }

      // Search for a match (case-insensitive)
      var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
      this.element.children( "option" ).each(function() {
        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
          this.selected = valid = true;
          return false;
        }
      });

      // Found a match, nothing to do
      if ( valid ) {
        return;
      }

      // Remove invalid value
      this.input
        .val( "" )
        .tooltip( "open" );
      this.element.val( "" );
      this._delay(function() {
        this.input.tooltip( "close" ).attr( "title", "" );
      }, 2500 );
      this.input.autocomplete( "instance" ).term = "";
    },

    _destroy: function() {
      this.wrapper.remove();
      this.element.show();
    }
  });

    $("#combobox1").combobox();
    $("#combobox-edit").combobox();
    $(document).ready(function(){
      // Add new element
      $("#tambah-kolom").click(function(){
        console.log(max);
        // Finding total number of elements added
        var total_element = $(".element").length;
                    
        // last <div> with element class id
        var lastid = $(".element:last").attr("id");
        var split_id = lastid.split("_");
        var nextindex = Number(split_id[1]) + 1;

        // Check total number elements
        if(total_element < max ){
            // Adding new div container after last occurance of element class
            $(".element:last").after(`<div class="element col s12" id="div_`+ nextindex +`"></div>`);
                        
            // Adding element to <div>
            $("#div_" + nextindex).append(`
              <div id="txt_`+ nextindex +`">
                <div class="card-panel bg">
                  <a class="remove waves-effect waves-light btn red darken-1" id="remove_`+ nextindex +`"><i class="material-icons">close</i></a>
                  <div class="row">
                    <div class="col s12 m6">
                      <div class="ui-widget input-field">
                        <select id="combobox`+ nextindex +`" name="id_barang[]" required>
                        </select>
                        <label class="active">Pilih Barang</label>
                      </div>
                    </div>
                    <div class="input-field col s12 m6">
                      <input placeholder="" id="jum_yg_dibeli`+nextindex+`" type="number" class="validate" name="jum_yg_dibeli[]" required>
                      <label for="jum_yg_dibeli`+nextindex+`" class="active">Jumlah Barang Yang Dibeli</label>
                    </div>
                  </div>
                </div>  
              </div>
            `);
            $("#combobox"+nextindex).combobox(); 
            $(".datepicker"+nextindex).datepicker({
              format: 'yyyy-mm-dd'
            });
            $.ajax({
              url: "asset/js/ajax-list-barang.php",
              method: "GET",
              dataType: "html"
            }).done(function(msg) {
              $("#combobox"+nextindex).html(msg);
            }); 
        }
        max++;            
      });

      // Remove element
      $('.container').on('click','.remove',function(){
                  
          var id = this.id;
          var split_id = id.split("_");
          var deleteindex = split_id[1];

          // Remove <div> with id
          $("#div_" + deleteindex).remove();
      });
    });
} );
