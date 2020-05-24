<?php

class Designer
{
    /**
     * @var array Тут считанная из файла хтмлька
     */
    private $html;

    public function __construct()
    {
        // получаем хтмльку для парсинга, если там будет не хтмлька то наверное наступит смерть
        // парсинг точно полетит
        if ($fh = fopen(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'design' . DIRECTORY_SEPARATOR . 'design.html', 'r')) {
            while (!feof($fh)) {
                $this->html[] = fgets($fh);
            }
            fclose($fh);
        }
    }

    /**
     * Возвращает собранный head в виде массива.
     *
     * @param $pagename
     * @return array
     */
    public function getHeadContents($pagename)
    {
        $head = $this->parse($this->html, 'head');
        $titleHtml = $this->parse($head, 'title');
        $titleHtml = $this->switchPlaceholder($titleHtml, $pagename);
        $head = $this->fillBlockWithItems($head, 'title', [$titleHtml]);
        return $head;
    }

    /**
     * По переданному списку доступных станков создаем селектор
     *
     * @return array
     */
    public function getChooseMachineHtml($machineArr)
    {
        $html = $this->parse($this->html, 'chooseMachine');
        $chooseMachineItemHtml = $this->parse($html, 'chooseMachineItem');
        $items = [];
        foreach ($machineArr as $machine) {
//            $option = $this->createSelectOption($machine);
//            $items[] = $this->switchPlaceholder($chooseMachineItemHtml, $option);
            $items[] = $this->switchPlaceholder($chooseMachineItemHtml, $machine);
        }
        $html = $this->fillBlockWithItems($html, 'chooseMachineItem', $items);
        return $html;
    }

    /**
     * Крафтим опцию для селектора с переданными value и title
     *
     * @param $value
     * @param bool $title
     * @return string
     */
    public function createSelectOption($value, $title = false)
    {
        if ($title === false || !is_string($title))
            $title = $value;
        $optionHtml =  "<option value=\"" . $value . "\">" . $title . "</option>\n";
        return $optionHtml;
    }

    /**
     * Возвращает календарь из шаблона
     * @return array
     */
    public function getCalendar()
    {
        $html = $this->parse($this->html, 'calendar');
        return $html;
    }

    /**
     * Возвращает подвал.
     *
     * @return array
     */
    public function getFooter()
    {
        return $this->parse($this->html, 'footer');
    }

    public function drawPage($modules)
    {
        foreach ($modules as $module)
            foreach ($module as $row)
                echo $row;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///
    /// Выше юзабельные снаружи методы, для получения всякого. Ниже - тулзы для парсинга.
    ///
    /////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Лень две строки писать каждый раз.
     *
     * @param $source
     * @param $blockName
     * @param $items
     * @return array
     */
    public function fillBlockWithItems($source, $blockName, $items)
    {
        $result = $this->replaceBlockWithPlaceholder($source, $blockName);
        $result = $this->switchPlaceholder($result, $items);
        return $result;
    }

    /**
     * Подмена плэйсхолдера на что то переданное, строку или массив.
     * $source - эт массив с хтмлькой для выборки.
     *
     * @param array $source
     * @param string|array $items
     * @return array
     */
    public function switchPlaceholder($source, $items)
    {
        if (is_array($items)) {
            return $this->_switchPlaceholderArray($source, $items);
        } else {
            return $this->_switchPlaceholderString($source, $items);
        }
    }

    /**
     * Подмена плэйсхолдера на строку.
     *
     * @param array $source
     * @param string $items
     * @return array
     */
    public function _switchPlaceholderString($source = [], $items = "")
    {
        foreach ($source as &$htmlRow) {
            if (preg_match('/<!--placeholder-->/', $htmlRow)) {
                $htmlRow = $items;
            }
        }
        return $source;
    }

    /**
     * Подмена плэйсхолдера на массив.
     * $items - должны приходить как массив массивов.
     *
     * @param array $source
     * @param array $items
     * @return array
     */
    public function _switchPlaceholderArray($source = [], $items = [], $once = true)
    {
        $result = [];
        $check = true;
        foreach ($source as $htmlRow) {
            if (preg_match('/<!--placeholder-->/', $htmlRow)) {
                if ($once && $check) {
                    foreach ($items as $item) {
                        foreach ($item as $row) {
                            $result[] = $row;
                        }
                    }
                }
                if ($once)
                    $check = false;
            } else {
                $result[] = $htmlRow;
            }
        }
        return $result;
    }

    /**
     * Убрать из массива с хтмл какой то блок ограниченный указанным комментарием,
     * чтобы подменить его потом на что либо с switchPlaceholder().
     *
     * @param $source
     * @param $blockName
     * @return array
     */
    public function replaceBlockWithPlaceholder($source, $blockName)
    {
        $skip = false;
        $result = [];
        foreach ($source as $row) {
            if ($skip) {
                if (preg_match('/<!--' . $blockName . '-->/', $row)) {
                    $skip = false;
                    $result[] = '<!--placeholder-->';
                }
            } elseif (preg_match('/<!--' . $blockName . '-->/', $row)) {
                $skip = true;
            } else {
                $result[] = $row;
            }
        }
        return $result;
    }

    /**
     * Возвращает из массива-выборки массив содержащий хтмл внутри указанного комментария.
     *
     * @param array $html
     * @param string $tag
     * @return array
     */
    public function parse($html = array(), $tag = '')
    {
        $ids = [];
        foreach ($html as $id => $row) {
            if (preg_match('/<!--' . $tag . '-->/', $row)) {
                $ids[] = $id;
            }
        }
        $range = range($ids[0], $ids[1]);
        array_shift($range);
        array_pop($range);
        $result = [];
        foreach ($range as $id) {
            $result[] = $html[$id];
        }
        return $result;
    }
}