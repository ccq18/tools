<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model\Account{
/**
 * App\Model\Account\Account
 *
 * @mixin \Eloquent
 * @property int $id
 * @property float $uid
 * @property float $type 1 可用余额 2 冻结金额
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereUpdatedAt($value)
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\Account whereTitle($value)
 */
	class Account extends \Eloquent {}
}

namespace App\Model\Account{
/**
 * App\Model\Account\AccountLog
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $account_id 账户
 * @property int $transfer_id 转让记录
 * @property string $title 标题
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereUpdatedAt($value)
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountLog whereAmount($value)
 */
	class AccountLog extends \Eloquent {}
}

namespace App\Model\Account{
/**
 * App\Model\Account\AccountTransfer
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $from_uid 转出人
 * @property int $to_uid 转入人
 * @property int $from_account_id 转出账户
 * @property int $to_account_id 转入账户
 * @property string $biz_id 业务订单号
 * @property int $biz_type 业务类型
 * @property string $title
 * @property int $status 1 成功 2 失败 3 撤回
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereBizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereBizType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereFromAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereFromUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereToAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereToUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\AccountTransfer whereUpdatedAt($value)
 */
	class AccountTransfer extends \Eloquent {}
}

namespace App\Model\Account{
/**
 * App\Model\Account\SystemAccounts
 *
 * @property int $id
 * @property int $uid
 * @property int $account_id
 * @property int $type 1 充值账户
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Account\SystemAccount whereUid($value)
 * @mixin \Eloquent
 * @property-read \App\Model\Account\Account $account
 */
	class SystemAccount extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Answer
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $question_id
 * @property string $body
 * @property int $votes_count
 * @property int $comments_count
 * @property string $is_hidden
 * @property string $close_comment
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Comment[] $comments
 * @property-read \App\Model\Question $question
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCloseComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Answer whereVotesCount($value)
 * @mixin \Eloquent
 */
	class Answer extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Article
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Article extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Comment
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property string $body
 * @property int $commentable_id
 * @property string $commentable_type
 * @property int|null $parent_id
 * @property int $level
 * @property string $is_hidden
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Comment whereUid($value)
 * @mixin \Eloquent
 */
	class Comment extends \Eloquent {}
}

namespace App\Model\Finance{
/**
 * App\Model\Finance\Stock
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $unit 计价单位 美元 人民币
 * @property int $type 类型 1 上海 2 深圳 3 美股 4 港股  5 比特币
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\Stock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Stock extends \Eloquent {}
}

namespace App\Model\Finance{
/**
 * App\Model\Finance\StockLog
 *
 * @property int $id
 * @property int $stock_id
 * @property float $price
 * @property float $price_change
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog wherePriceChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereStockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float $market_value 市值
 * @property int $turnover 成交量
 * @property int $circulation 发行量
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereCirculation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereMarketValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereTurnover($value)
 * @property float|null $open_price 开盘价
 * @property float|null $close_price 收盘价
 * @property float|null $high_price 最高价
 * @property float|null $low_price 最低价
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereClosePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereHighPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereLowPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Finance\StockLog whereOpenPrice($value)
 */
	class StockLog extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Follow
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $question_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Follow whereUid($value)
 * @mixin \Eloquent
 */
	class Follow extends \Eloquent {}
}

namespace App\Model\Github{
/**
 * App\Model\Github\GithubRepository
 *
 * @property int $id
 * @property string $repository_url
 * @property string $repository_name
 * @property string $author_url
 * @property string $language
 * @property string $remark
 * @property int $status
 * @property int $star
 * @property int $fork
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereAuthorUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereFork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRepositoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRepositoryUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class GithubRepository extends \Eloquent {}
}

namespace App\Model\Lang{
/**
 * App\Model\Lang\Sent
 *
 * @property int $id
 * @property string $orig 句子
 * @property string $trans 翻译
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereOrig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereTrans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Sent whereUpdatedAt($value)
 */
	class Sent extends \Eloquent {}
}

namespace App\Model\Lang{
/**
 * App\Model\Lang\Word
 *
 * @property int $id
 * @property int $book_id
 * @property int $number
 * @property string $word
 * @property string $base_str
 * @property array $translate
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereBaseStr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereTranslate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereWord($value)
 * @mixin \Eloquent
 * @property string|null $sent 例句id数组
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Lang\Word whereSent($value)
 */
	class Word extends \Eloquent {}
}

namespace App\Model\Loan{
/**
 * App\Model\Loan\Loan
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property string $apr
 * @property string $title
 * @property string $content
 * @property int $uid
 * @property float $amount
 * @property int $loan_status
 * @property string|null $started_at 开始时间
 * @property string|null $ended_at 结束时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereApr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereLoanStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\Loan whereUid($value)
 */
	class Loan extends \Eloquent {}
}

namespace App\Model\Loan{
/**
 * App\Model\Loan\LoanRecord
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $loan_id
 * @property int $uid
 * @property float $money
 * @property float $scale
 * @property string|null $started_at 开始时间
 * @property string|null $ended_at 结束时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereLoanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereScale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRecord whereUpdatedAt($value)
 */
	class LoanRecord extends \Eloquent {}
}

namespace App\Model\Loan{
/**
 * App\Model\Loan\LoanRepayment
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $money
 * @property string|null $repayment_at
 * @property string|null $real_repayment_at
 * @property int $repayment_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRealRepaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRepaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereRepaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepayment whereUpdatedAt($value)
 */
	class LoanRepayment extends \Eloquent {}
}

namespace App\Model\Loan{
/**
 * App\Model\Loan\LoanRepaymentRecord
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property int $form_account_id
 * @property float $amount
 * @property string|null $real_payment_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereFormAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereRealPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Loan\LoanRepaymentRecord whereUpdatedAt($value)
 */
	class LoanRepaymentRecord extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Message
 *
 * @package App
 * @property int $id
 * @property int $from_uid
 * @property int $to_uid
 * @property string $body
 * @property string $has_read
 * @property string|null $read_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $dialog_id
 * @property-read \App\Model\User $fromUser
 * @property-read \App\Model\User $toUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereDialogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereFromUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereHasRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereToUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Message extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Post
 *
 * @property int $id
 * @property int $uid
 * @property string $title
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Post whereUid($value)
 * @mixin \Eloquent
 */
	class Post extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Question
 *
 * @package App
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $uid
 * @property int $comments_count
 * @property int $followers_count
 * @property int $answers_count
 * @property string $close_comment
 * @property string $is_hidden
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Topic[] $topics
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCloseComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereIsHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Question whereUid($value)
 * @mixin \Eloquent
 */
	class Question extends \Eloquent {}
}

namespace App\Model{
/**
 * Class SystemUser
 *
 * @package App\Model
 * @property-read \App\Model\Account\Account[] $accounts
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $confirmation_token
 * @property int $is_active
 * @property int $questions_count
 * @property int $answers_count
 * @property int $comments_count
 * @property int $favorites_count
 * @property int $likes_count
 * @property int $followers_count
 * @property int $followings_count
 * @property array $settings
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $api_token
 * @property int|null $account_id
 * @property int|null $frozen_account_id
 * @property int $type 1 普通用户 2 系统用户
 * @property-read \App\Model\Account\Account $account
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followersUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $follows
 * @property-read \App\Model\Account\Account $frozenAccount
 * @property-read \App\Model\MessageCollection|\App\Model\Message[] $messages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFavoritesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFollowingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereFrozenAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SystemUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class SystemUser extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Task
 *
 * @property int $id
 * @property string $domain
 * @property string $hash
 * @property string $task_url
 * @property string $type
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereTaskUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $parse_status 解析状态 1 未解析 2 已解析
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereParseStatus($value)
 * @property-read \App\Model\TaskDocument $taskDocument
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Task whereHash($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\TaskDocument
 *
 * @property int $id
 * @property int $task_id
 * @property string $page_content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument wherePageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\TaskDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class TaskDocument extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Topic
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string|null $bio
 * @property int $questions_count
 * @property int $followers_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $questions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Topic whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Topic extends \Eloquent {}
}

namespace App\Model{
/**
 * Class User
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $confirmation_token
 * @property int $is_active
 * @property int $questions_count
 * @property int $answers_count
 * @property int $comments_count
 * @property int $favorites_count
 * @property int $likes_count
 * @property int $followers_count
 * @property int $followings_count
 * @property array $settings
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $api_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $answers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\User[] $followersUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Question[] $follows
 * @property-read \App\Model\MessageCollection|\App\Model\Message[] $messages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Answer[] $votes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAnswersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCommentsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFavoritesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFollowersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFollowingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereLikesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereQuestionsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $account_id
 * @property int|null $frozen_account_id
 * @property int $type 1 普通用户 2 系统用户
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereFrozenAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereType($value)
 * @property-read \App\Model\Account\Account $account
 * @property-read \App\Model\Account\Account $frozenAccount
 */
	class User extends \Eloquent {}
}

namespace App\Model\Vagrant{
/**
 * App\Model\Vagrant\Vagrant
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $status 状态 1已创建 2 已停止 3 运行中
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereTemplatePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $vagrant_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereVagrantFile($value)
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\Vagrant whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Model\Vagrant\Vagrant withoutTrashed()
 */
	class Vagrant extends \Eloquent {}
}

namespace App\Model\Vagrant{
/**
 * App\Model\Vagrant\VagrantLog
 *
 * @property int $id
 * @property string $vagrant_id
 * @property string $content
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vagrant\VagrantLog whereVagrantId($value)
 * @mixin \Eloquent
 */
	class VagrantLog extends \Eloquent {}
}

namespace App\Model{
/**
 * Class Vote
 *
 * @package App
 * @property int $id
 * @property int $uid
 * @property int $answer_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Vote whereUid($value)
 * @mixin \Eloquent
 */
	class Vote extends \Eloquent {}
}

