<?php
namespace BestPlan;

class Broadbands
{
    public function getAll()
    {
        $data = $this->getData();

        $packages = [];
        for ($i = 1; $i <= count($data); $i++) {
            $packages = array_merge($packages, $this->getPackages($data, $i));
        }
        unset($data, $i);

        $result = [];
        foreach ($packages as $package) {
            $price = array_sum($package['prices']);
            if (count($package['items']) > 1) {
                $price = array_sum($package['prices']) + array_sum($package['additionals']) - array_sum($package['discounts']);
            }

            $result[] = [
                'title' => implode(' + ', $package['items']),
                'price' => $price,
                'items' => $package['items']
            ];
        }
        unset($packages, $package);

        usort($result, function($actual, $next) {
            if ((float) $actual['price'] == (float) $next['price']) {
                return 0;
            }

            return ((float) $actual['price'] < (float) $next['price']) ? -1 : 1;
        });

        return $result;
    }

    private function getData()
    {
        $str = file_get_contents("data.json", FILE_USE_INCLUDE_PATH);
        if ($str === false) {
            return [];
        }

        $data = json_decode($str, true);
        unset($str);

        return $this->prepareData($data);
    }

    private function prepareData($data)
    {
        $prepared[] = array_filter($data, function($item) {
            return (trim($item['type']) == 'bb');
        });
        $prepared[] = array_filter($data, function($item) {
            return (trim($item['type']) == 'll');
        });
        $prepared[] = array_filter($data, function($item) {
            return (trim($item['type']) == 'tv');
        });
        $prepared[] = array_filter($data, function($item) {
            return (trim($item['type']) == 'addon');
        });

        return $prepared;
    }

    private function getPackages($data, $size, &$bundles = array(), $package = array(), $item = null, $i = 0)
    {
        if (isset($item)) {
            // Check if item is bb, ll or tv
            if ($this->existsType($item['type'], ['bb', 'll', 'tv'])) {
                // Check if item already exists in package
                if (!$this->existsType($item['type'], $package)) {
                    $this->addItemPackage($package, $item);
                }
            } else {
                $this->addItemPackage($package, $item);
            }
        }

        if ($i >= $size) {
            array_push($bundles, $package);
        } else {
            foreach ($data[$i] as $nextItem) {
                $this->getPackages($data, $size, $bundles, $package, $nextItem, $i + 1);
            }
        }

        return $bundles;
    }

    private function existsType($needle, $haystack)
    {
        foreach ($haystack as $item) {
            if ($item === $needle || (is_array($item) && $this->existsType($needle, $item))) {
                return true;
            }
        }

        return false;
    }

    private function addItemPackage(&$package, $item)
    {
        if (empty($package)) {
            $package = [
                'items' => [$item['name']],
                'prices' => [isset($item['price']) ? (float) $item['price'] : 0],
                'additionals' => [isset($item['additional']) ? (float) $item['additional'] : 0],
                'discounts' => [isset($item['discount']) ? (float) $item['discount'] : 0]
            ];
        } else {
            $package['items'][] = $item['name'];
            $package['prices'][] = isset($item['price']) ? (float) $item['price'] : 0;
            $package['additionals'][] = isset($item['additional']) ? (float) $item['additional'] : 0;
            $package['discounts'][] = isset($item['discount']) ? (float) $item['discount'] : 0;
        }
    }
}
