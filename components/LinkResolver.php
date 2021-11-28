<?php
namespace app\components;

use yii\base\Component;
use app\models\Link;

class LinkResolver extends Component
{

    public function resolve(string $uri): ?string
    {

        $link = Link::find()->where(['token' => $uri])->one();

        if ($link === null) {
            return null;
        }

        if ($this->isAvailable($link)) {
            $this->incrementViews($link);
        } else {
            $this->removeLink($link);
            
            return null;
        }

        return $link->full_url;
    }

    private function isAvailable(Link $link): bool
    {
        if ($link->expires_at >= time() AND ($link->limit == 0 OR ($link->limit != 0 AND $link->views < $link->limit))) {
            return true;
        }

        return false;
    }

    private function incrementViews(Link $link): void
    {
        $link->views++;
        $link->save();
    }

    private function removeLink(Link $link): void
    {
        $link->delete();
    }
}
