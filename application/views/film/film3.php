<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#aabcfe;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.tg .tg-6nwz{font-size:14px;text-align:center;vertical-align:top}
.tg .tg-yw4l{vertical-align:top}
th.tg-sort-header::-moz-selection { background:transparent; }
th.tg-sort-header::selection      { background:transparent; }
th.tg-sort-header { cursor:pointer; }
table th.tg-sort-header:after {  content:'';  float:right;  margin-top:7px;  border-width:0 4px 4px;  border-style:solid;  border-color:#404040 transparent;  visibility:hidden;  }
table th.tg-sort-header:hover:after {  visibility:visible;  }
table th.tg-sort-desc:after,table th.tg-sort-asc:after,table th.tg-sort-asc:hover:after {  visibility:visible;  opacity:0.4;  }
table th.tg-sort-desc:after {  border-bottom:none;  border-width:4px 4px 0;  }
@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;}}
#pagination a, #pagination strong{background: #b9c9fe;padding: 4px 7px;border: 1px solid #cac9c9;color: #292929;font-size: 18px;}
#pagination strong, #pagin0ation a:hover{font-weight: normal;background: #e8edff;}
.sort_asc:after{content: "^";}
.sort_desc:after{content: "v";}
label{display: inline-block;width: 120px;}
</style>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-6 col-md-4">
      <?=form_open('films3/search');?>
      <div>
        <?=form_label('Title', 'title');
        echo form_input('title', set_value('title'), 'id="title"');?>
      </div>
      <div>
        <?=form_label('Category', 'category');
        echo form_dropdown('category', $category_options, set_value('category'), 'id="category"');?>
      </div>
      <div>
        <?=form_label('Length', 'length');
          echo form_dropdown('length_comparation', [
            'gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<'],
            set_value('length_comparation'), 'id="length_comparation"');
          echo form_input('length', set_value('length'), 'id="length"');?>
      </div>
      <div>
        <?=form_submit('action', 'Search');?>
      </div>
      <?=form_close();?>
    </div>
    <div class="col-xs-6 col-md-4">
      <div class="tg-wrap">
        Found <?=$num_results?> films
        <table id="tg-gnYkL" class="tg">
          <tr>
              <?php foreach($fields as $field_name => $field_display):?>
                <th class="tg-6nwz">
                  <div <?php if($sort_by == $field_name) echo "class='sort_$sort_order'"?>>
                    <?=anchor("films3/display/$query_id/$field_name/" .
                                  (($sort_order == 'asc' && $sort_by == $field_name) ? 'desc' : 'asc' ),
                                   $field_display);?>
                  </div>
                 </th>
              <?php endforeach;?>
          </tr>
          <?php foreach($films as $film):?>
          <tr>
            <?php foreach($fields as $field_name => $field_display):?>
                <td class="tg-yw4l"><?=$film->$field_name?></td>
            <?php endforeach;?>
          </tr>
          <?php endforeach;?>
        </table>
        <?php if(strlen($pagination)):?>
          <nav>
            <ul class="pagination">
              <li class="disabled"><?=$pagination?></li>
            </ul>
          </nav>
        <?php endif;?>
      </div>
    </div>
    <div class="col-xs-6 col-md-4"></div>
  </div>
</div>
<script type="text/javascript" charset="utf-8">
var TgTableSort=window.TgTableSort||function(n,t){"use strict";function r(n,t){for(var e=[],o=n.childNodes,i=0;i<o.length;++i){var u=o[i];if("."==t.substring(0,1)){var a=t.substring(1);f(u,a)&&e.push(u)}else u.nodeName.toLowerCase()==t&&e.push(u);var c=r(u,t);e=e.concat(c)}return e}function e(n,t){var e=[],o=r(n,"tr");return o.forEach(function(n){var o=r(n,"td");t>=0&&t<o.length&&e.push(o[t])}),e}function o(n){return n.textContent||n.innerText||""}function i(n){return n.innerHTML||""}function u(n,t){var r=e(n,t);return r.map(o)}function a(n,t){var r=e(n,t);return r.map(i)}function c(n){var t=n.className||"";return t.match(/\S+/g)||[]}function f(n,t){return-1!=c(n).indexOf(t)}function s(n,t){f(n,t)||(n.className+=" "+t)}function d(n,t){if(f(n,t)){var r=c(n),e=r.indexOf(t);r.splice(e,1),n.className=r.join(" ")}}function v(n){d(n,L),d(n,E)}function l(n,t,e){r(n,"."+E).map(v),r(n,"."+L).map(v),e==T?s(t,E):s(t,L)}function g(n){return function(t,r){var e=n*t.str.localeCompare(r.str);return 0==e&&(e=t.index-r.index),e}}function h(n){return function(t,r){var e=+t.str,o=+r.str;return e==o?t.index-r.index:n*(e-o)}}function m(n,t,r){var e=u(n,t),o=e.map(function(n,t){return{str:n,index:t}}),i=e&&-1==e.map(isNaN).indexOf(!0),a=i?h(r):g(r);return o.sort(a),o.map(function(n){return n.index})}function p(n,t,r,o){for(var i=f(o,E)?N:T,u=m(n,r,i),c=0;t>c;++c){var s=e(n,c),d=a(n,c);s.forEach(function(n,t){n.innerHTML=d[u[t]]})}l(n,o,i)}function x(n,t){var r=t.length;t.forEach(function(t,e){t.addEventListener("click",function(){p(n,r,e,t)}),s(t,"tg-sort-header")})}var T=1,N=-1,E="tg-sort-asc",L="tg-sort-desc";return function(t){var e=n.getElementById(t),o=r(e,"tr"),i=o.length>0?r(o[0],"td"):[];0==i.length&&(i=r(o[0],"th"));for(var u=1;u<o.length;++u){var a=r(o[u],"td");if(a.length!=i.length)return}x(e,i)}}(document);document.addEventListener("DOMContentLoaded",function(n){TgTableSort("tg-gnYkL")});
</script>