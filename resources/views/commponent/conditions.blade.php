<div class="popup">
    <div class="content">
        <!-- デプロイ時URL変更 -->
        <form action="../conditions" method="post">
            @csrf
            <fieldset>
                <legend>場所・地域</legend>
                <select name="areacode_s" style="max-width: 265px;">
                    @foreach($GAreaSmallSearchData['garea_small'] as $data )
                    <option value="{{ $data['areacode_s'] }}">
                        {{ $data['pref']['pref_name'] }}:{{ $data['areaname_s'] }}
                    </option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset>
                <legend>食べ物・ジャンル</legend>
            </fieldset>
            <select name="category_l">
                @foreach($CategoryLargeSearchData['category_l'] as $data)
                <option value="{{ $data['category_l_code'] }}">
                    {{ $data['category_l_name'] }}
                </option>
                @endforeach
            </select>
            <fieldset>
                <legend>その他</legend>
                <label><input type="checkbox" name="card" value="1" class="checkbox">カード払いOK</label>
                <label><input type="checkbox" name="bottomless_cup" value="1" class="checkbox">飲み放題</label>
                <label><input type="checkbox" name="no_smoking" value="1" class="checkbox">喫煙席あり</label>
                <label><input type="checkbox" name="private_room" value="1" class="checkbox">個室</label>
                <label><input type="checkbox" name="buffet" value="1" class="checkbox">食べ放題</label>
                <label><input type="checkbox" name="parking" value="1" class="checkbox">駐車場</label>
                <label><input type="checkbox" name="midnight" value="1" class="checkbox">深夜営業</label>
            </fieldset>
            <div class="popupButtonArea">
                <button type="submit" class="btn btn-primary" id="letSearch">検索</button>
                <button type="button" class="btn" id="close">閉じる</button>
            </div>
        </form>
    </div>
</div>
