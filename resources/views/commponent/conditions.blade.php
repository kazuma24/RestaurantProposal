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
                <label><input type="checkbox" name="card" value="1" class="checkbox">クレカ</label>
                <label><input type="checkbox" name="bottomless_cup" value="1" class="checkbox">のみほ</label>
                <label><input type="checkbox" name="no_smoking" value="1" class="checkbox">たばこ</label>
                <label><input type="checkbox" name="private_room" value="1" class="checkbox">こしつ</label>
                <label><input type="checkbox" name="buffet" value="1" class="checkbox">たべほ</label>
                <label><input type="checkbox" name="parking" value="1" class="checkbox">駐車場</label>
                <label><input type="checkbox" name="midnight" value="1" class="checkbox">朝まで！</label>
            </fieldset>
            <div class="popupButtonArea">
                <button type="submit" class="btn btn-primary" id="letSearch">けんさく</button>
                <button type="button" class="btn btn-danger" id="close">とじる</button>
            </div>
        </form>
    </div>
</div>
