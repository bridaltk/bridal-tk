var addComment = {
    moveForm: function (commId, parentId, respondId, postId) {
        var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');

        if (!comm || !respond || !cancel || !parent)
            return;

        t.respondId = respondId;
        postId = postId || false;

        if (!t.I('wp-temp-form-div')) {
            div = document.createElement('div');
            div.id = 'wp-temp-form-div';
            div.style.display = 'none';
            respond.parentNode.insertBefore(div, respond);
        }

        respond.style.display = '';
        comm.parentNode.insertBefore(respond, comm.nextSibling);
        if (post && postId)
            post.value = postId;
        parent.value = parentId;
        cancel.style.display = '';

        cancel.onclick = function () {
            var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

            if (!temp || !respond)
                return;

            t.I('comment_parent').value = '0';
            temp.parentNode.insertBefore(respond, temp);
            temp.parentNode.removeChild(temp);
            temp.innerHTML=respond;
            this.style.display = 'none';
            this.onclick = null;
            return false;
        };

        var newfocus = 'comment';

        if ('respond_extra' == respondId) {
            newfocus = 'comment_extra';
        } else if ('respond' == respondId) {
            newfocus = 'comment';
        }

        try {
            t.I(newfocus).focus();
        }
        catch (e) {
        }


        return false;
    },
    I: function (e) {
        return document.getElementById(e);
    }
};