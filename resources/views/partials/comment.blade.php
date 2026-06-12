<div class="comment-thread" id="comment-{{ $comment->id }}" data-comment-id="{{ $comment->id }}">
    <div class="comment-card">
        <img src="{{ $comment->user->avatar_url }}" class="comment-avatar" alt="{{ $comment->user->name }}">
        <div class="comment-content">
            <div class="comment-header">
                <span class="comment-author">{{ $comment->user->name }}</span>
                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="comment-text" id="comment-text-{{ $comment->id }}">
                <p>{{ $comment->content }}</p>
            </div>
            <div class="comment-actions">
                @auth
                    <button class="comment-action-btn" onclick="showReplyForm({{ $comment->id }})">
                        <i class="fas fa-reply me-1"></i> Reply
                    </button>
                    @if(Auth::id() == $comment->user_id)
                        <button class="comment-action-btn" onclick="editComment({{ $comment->id }})">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <button class="comment-action-btn text-danger" onclick="deleteComment({{ $comment->id }})">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    
    <div class="reply-form-wrapper" id="replyForm-{{ $comment->id }}">
        <form onsubmit="submitReply(event, {{ $comment->id }})">
            <textarea class="reply-input" rows="2" placeholder="Write your reply..." required></textarea>
            <div style="margin-top: 10px;">
                <button type="submit" class="btn-submit-sm">Post Reply</button>
                <button type="button" class="btn-cancel" onclick="hideReplyForm({{ $comment->id }})">Cancel</button>
            </div>
        </form>
    </div>
    
    <div class="replies-container" id="replies-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
            @include('partials.reply', ['reply' => $reply])
        @endforeach
    </div>
</div>