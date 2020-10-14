<div class="freeWordPopup">
    <div class="freeWordContent">
        <form action="
        /freeword" method="post" id="freeWordForm">
            @csrf
            <fieldset>
                <legend>ふりーわーど</legend>
                <input type="text" name="freeword" id="freeWordText">
                <p>
                    ふりーわーどは以下の例で検索してね<br>
                    例１：札幌駅、居酒屋、3000円<br>
                    例２：東京駅、焼肉、飲み放題<br>
                    例３：大阪、難波、お好み焼き<br>
                    ※ふりーわーどは3個まで！<br>
                    あ。ふりーわーどは「、」で区切って入力してね。<br>
                </p>
                <p style="color: brown;">※ふりーわーどによっては、機械が店を見つけれんかも..</p>
            </fieldset>
            <div class="popupButtonArea">
                <button type="submit" class="btn btn-primary" id="freeWordSearch">けんさく</button>
                <button type="button" class="btn btn-danger" id="freeWordPopupClose">とじる</button>
            </div>
        </form>
    </div>
</div>
