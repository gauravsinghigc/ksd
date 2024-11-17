<?php require "plot-config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 <link href="style.css" rel="stylesheet" />
 <link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
 <title>Sahapur Project Map</title>
 <style>
 <?php include "config.css";
 ?>

 </style>
</head>

<body>
 <div class="container" style="width:480px !important;border:none !important;">
      
      <div class="box">
        <img src="img/compass.png" alt="">
        <!------boundry------>
        <div class="line"></div>
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
        <div class="line4"></div>
        <div class="line5"></div>
        <div class="line6"></div>
          <div class="linea" >
  
        </div>
        <!--------road----->
        <div class="road"></div>
        <div class="road1"></div>
        <div class="road2"></div>
        <div class="road3"></div>
        <div class="road4"></div>
        <div class="road5"></div>
        <div class="road6"></div>
        <div class="road7"></div>
        <div class="road8"></div>
        <div class="road9"></div>
        <div class="road10"></div>
        <div class="road11"></div>
        <div class="road12"></div>

        <!-------hr----->
        <div class="hr"></div>

        <!------start plot------>

        <div class="p1 plot1" onmouseover="ShowDetails(p1)" id="p1">p1</div>
          <div class="p2 plot0" onmouseover="ShowDetails(p2)" id="p2">p2</div>
          <div class="p3 plot0" onmouseover="ShowDetails(p3)" id="p3">p3</div>
          <div class="p4 plot0" onmouseover="ShowDetails(p4)" id="p4">p4</div>
          <div class="p5 plot0" onmouseover="ShowDetails(p5)" id="p5">p5</div>
          <div class="p6 plot0" onmouseover="ShowDetails(p6)" id="p6">p6</div>
          <div class="p7 plot0" onmouseover="ShowDetails(p7)" id="p7">p7</div>
          <div class="p8 plot0" onmouseover="ShowDetails(p8)" id="p8">p8</div>
          <div class="p9 plot0" onmouseover="ShowDetails(p9)" id="p9">p9</div>
          <div class="p10 plot0" onmouseover="ShowDetails(p10)" id="p10">p10</div>
          <div class="p11 plot0" onmouseover="ShowDetails(p11)" id="p11">p12</div>
          <div class="p12 plot0" onmouseover="ShowDetails(p12)" id="p12">p12</div>
          <div class="p13 plot0" onmouseover="ShowDetails(p13)" id="p13">p13</div>
          <div class="p14 plot0" onmouseover="ShowDetails(p14)" id="p14">p14</div>
          <div class="p15 plot0" onmouseover="ShowDetails(p15)" id="p15">p15</div>
          <div class="p16 plot0" onmouseover="ShowDetails(p16)" id="p16">p16</div>
          <div class="p17 plot0" onmouseover="ShowDetails(p17)" id="p17">p17</div>
          <div class="p18 plot0" onmouseover="ShowDetails(p18)" id="p18">p18</div>
          <div class="p19 plot0" onmouseover="ShowDetails(p19)" id="p19">p19</div>
          <div class="p20 plot0" onmouseover="ShowDetails(p20)" id="p20">p20</div>
          <div class="p21 plot0" onmouseover="ShowDetails(p21)" id="p21">p21</div>
          <div class="p22 plot0" onmouseover="ShowDetails(p22)" id="p22">p22</div>
          <div class="p23 plot0" onmouseover="ShowDetails(p23)" id="p23">p23</div>
          <div class="p24 plot0" onmouseover="ShowDetails(p24)" id="p24">p24</div>
          <div class="p25 plot0" onmouseover="ShowDetails(p25)" id="p25">p25</div>
          <div class="p26 plot0" onmouseover="ShowDetails(p26)" id="p26">p26</div>
          <div class="p27 plot0" onmouseover="ShowDetails(p27)" id="p27">p27</div>
          <div class="p28 plot0" onmouseover="ShowDetails(p28)" id="p28">p28</div>
          <div class="p29 plot0" onmouseover="ShowDetails(p29)" id="p29">p29</div>
          <div class="commercial" onmouseover="ShowDetails(commercial)" id="commercial">C.A</div>
          <div class="p30 plot0" onmouseover="ShowDetails(p30)" id="p30">p30</div>
          <div class="p31 plot0" onmouseover="ShowDetails(p31)" id="p31">p31</div>
          <div class="p32 plot0" onmouseover="ShowDetails(p32)" id="p32">p32</div>
          <div class="p33 plot0" onmouseover="ShowDetails(p33)" id="p33">p33</div>
          <div class="p34 plot0" onmouseover="ShowDetails(p34)" id="p34">p34</div>
          <div class="p35 plot0" onmouseover="ShowDetails(p35)" id="p35">p35</div>
          <div class="p36 plot0" onmouseover="ShowDetails(p36)" id="p36">p36</div>
          <div class="p37 plot0" onmouseover="ShowDetails(p37)" id="p37">p37</div>
          <div class="p38 plot0" onmouseover="ShowDetails(p38)" id="p38">p38</div>
          <div class="p39 plot0" onmouseover="ShowDetails(p39)" id="p39">p39</div>
          <div class="p40 plot0" onmouseover="ShowDetails(p40)" id="p40">p40</div>
          <div class="p41 plot0" onmouseover="ShowDetails(p41)" id="p41">p41</div>
          <div class="p42 plot0" onmouseover="ShowDetails(p42)" id="p42">p42</div>
          <div class="p43 plot0" onmouseover="ShowDetails(p43)" id="p43">p43</div>
          <div class="p44 plot0" onmouseover="ShowDetails(p44)" id="p44">p44</div>
          <div class="p45 plot0" onmouseover="ShowDetails(p45)" id="p45">p45</div>
           <div class="p46 plot0" onmouseover="ShowDetails(p46)" id="p46">p46</div>
           <div class="p47 plot0" onmouseover="ShowDetails(p47)" id="p47">p47</div>
           <div class="p48 plot0" onmouseover="ShowDetails(p48)" id="p48">p48</div>
           <div class="p49 plot0" onmouseover="ShowDetails(p49)" id="p49">p49</div>
           <div class="p50 plot0" onmouseover="ShowDetails(p50)" id="p50">p50</div>
           <div class="p51 plot0" onmouseover="ShowDetails(p51)" id="p51">p51</div>
           <div class="p52 plot0" onmouseover="ShowDetails(p52)" id="p52">p52</div>
           <div class="p53 plot0" onmouseover="ShowDetails(p53)" id="p53">p53</div>
           <div class="p54 plot0" onmouseover="ShowDetails(p54)" id="p54">p54</div>
           <div class="p55 plot0" onmouseover="ShowDetails(p55)" id="p55">p55</div>
           <div class="p56 plot0" onmouseover="ShowDetails(p56)" id="p56">p56</div>
           <div class="p57 plot0" onmouseover="ShowDetails(p57)" id="p57">p57</div>
           <div class="p58 plot0" onmouseover="ShowDetails(p58)" id="p58">p58</div>
           <div class="p59 plot0" onmouseover="ShowDetails(p59)" id="p59">p59</div>
           <div class="p60 plot0" onmouseover="ShowDetails(p60)" id="p60">p60</div>
           <div class="p61 plot0" onmouseover="ShowDetails(p61)" id="p61">p61</div>
           <div class="p62 plot0" onmouseover="ShowDetails(p62)" id="p62">p62</div>
           <div class="p63 plot0" onmouseover="ShowDetails(p63)" id="p63">p63</div>
           <div class="p64 plot0" onmouseover="ShowDetails(p64)" id="p64">p64</div>
           <div class="p65 plot0" onmouseover="ShowDetails(p65)" id="p65">p65</div>
           <div class="p66 plot0" onmouseover="ShowDetails(p66)" id="p66">p66</div>
           <div class="p67 plot0" onmouseover="ShowDetails(p67)" id="p67">p67</div>
           <div class="p68 plot0" onmouseover="ShowDetails(p68)" id="p68">p68</div>
           <div class="p69 plot0" onmouseover="ShowDetails(p69)" id="p69">p69</div>
           <div class="p70 plot0" onmouseover="ShowDetails(p70)" id="p70">p70</div>
           <div class="p71 plot0" onmouseover="ShowDetails(p71)" id="p71">p71</div>
              <div class="p72 plot0" onmouseover="ShowDetails(p72)" id="p72">p72</div>
              <div class="p73 plot0" onmouseover="ShowDetails(p73)" id="p73">p73</div>
              <div class="p74 plot0" onmouseover="ShowDetails(p74)" id="p74">p74</div>
              <div class="p75 plot0" onmouseover="ShowDetails(p75)" id="p75">p75</div>
              <div class="p76 plot0" onmouseover="ShowDetails(p76)" id="p76">p76</div>
              <div class="p77 plot0" onmouseover="ShowDetails(p77)" id="p77">p77</div>
              <div class="p78 plot0" onmouseover="ShowDetails(p78)" id="p78">p78</div>
              <div class="p79 plot0" onmouseover="ShowDetails(p79)" id="p79">p79</div>
              <div class="p80 plot0" onmouseover="ShowDetails(p80)" id="p80">p80</div>
              <div class="p81 plot0" onmouseover="ShowDetails(p81)" id="p81">p81</div>
              <div class="p82 plot0" onmouseover="ShowDetails(p82)" id="p82">p82</div>
              <div class="p83 plot0" onmouseover="ShowDetails(p83)" id="p83">p83</div>
              <div class="p84 plot0" onmouseover="ShowDetails(p84)" id="p84">p84</div>
              <div class="p85 plot0" onmouseover="ShowDetails(p85)" id="p85">p85</div>
              <div class="p86 plot0" onmouseover="ShowDetails(p86)" id="p86">p86</div>
              <div class="p87 plot0" onmouseover="ShowDetails(p87)" id="p87">p87</div>
              <div class="p88 plot0" onmouseover="ShowDetails(p88)" id="p88">p88</div>
              <div class="p89 plot0" onmouseover="ShowDetails(p89)" id="p89">p89</div>
              <div class="p90 plot0" onmouseover="ShowDetails(p90)" id="p90">p90</div>
              <div class="p91 plot0" onmouseover="ShowDetails(p91)" id="p91">p91</div>
              <div class="p92 plot0" onmouseover="ShowDetails(p92)" id="p92">p92</div>
              <div class="p93 plot0" onmouseover="ShowDetails(p93)" id="p93">p93</div>
              <div class="p94 plot0" onmouseover="ShowDetails(p94)" id="p94">p94</div>
              <div class="p95 plot0" onmouseover="ShowDetails(p95)" id="p95">p95</div>
              <div class="p96 plot0" onmouseover="ShowDetails(p96)" id="p96">p96</div>
           <div class="p97 plot0" onmouseover="ShowDetails(p97)" id="p97">p97</div>
           <div class="p98 plot0" onmouseover="ShowDetails(p98)" id="p98">p98</div>
           <div class="p99 plot0" onmouseover="ShowDetails(p99)" id="p99">p99</div>
           <div class="p100 plot0" onmouseover="ShowDetails(p100)" id="p100">p100</div>
           <div class="p101 plot0" onmouseover="ShowDetails(p101)" id="p101">p101</div>
           <div class="p102 plot0" onmouseover="ShowDetails(p102)" id="p102">p102</div>
           <div class="p103 plot0" onmouseover="ShowDetails(p103)" id="p103">p103</div>
           <div class="p104 plot0" onmouseover="ShowDetails(p104)" id="p104">p104</div>
           <div class="p105 plot0" onmouseover="ShowDetails(p105)" id="p105">p105</div>
           <div class="p106 plot0" onmouseover="ShowDetails(p106)" id="p106">p106</div>
           <div class="p107 plot0" onmouseover="ShowDetails(p107)" id="p107">p107</div>
           <div class="p108 plot0" onmouseover="ShowDetails(p108)" id="p108">p108</div>
           <div class="p109 plot0" onmouseover="ShowDetails(p109)" id="p109">p109</div>
           <div class="p110 plot0" onmouseover="ShowDetails(p110)" id="p110">p110</div>
           <div class="p111 plot0" onmouseover="ShowDetails(p111)" id="p111">p111</div>
           <div class="p112 plot0" onmouseover="ShowDetails(p112)" id="p112">p112</div>
           <div class="p113 plot0" onmouseover="ShowDetails(p113)" id="p113">p113</div>
           <div class="p114 plot0" onmouseover="ShowDetails(p114)" id="p114">p114</div>
           <div class="p115 plot0" onmouseover="ShowDetails(p115)" id="p115">p115</div>
           <div class="p116 plot0" onmouseover="ShowDetails(p116)" id="p116">p116</div>
           <div class="p117 plot0" onmouseover="ShowDetails(p117)" id="p117">p117</div>
           <div class="p118 plot0" onmouseover="ShowDetails(p118)" id="p118">p118</div>
           <div class="p119 plot0" onmouseover="ShowDetails(p119)" id="p119">p119</div>
           <div class="p120 plot0" onmouseover="ShowDetails(p120)" id="p120">p120</div>
           <div class="p121 plot0" onmouseover="ShowDetails(p121)" id="p121">p121</div>
           <div class="p122 plot0" onmouseover="ShowDetails(p122)" id="p122">p122</div>
           <div class="p123 plot0" onmouseover="ShowDetails(p123)" id="p123">p123</div>
           <div class="p124 plot0" onmouseover="ShowDetails(p124)" id="p124">p124</div>
           <div class="p125 plot0" onmouseover="ShowDetails(p125)" id="p125">p125</div>
           <div class="p126 plot0" onmouseover="ShowDetails(p126)" id="p126">p126</div>
           <div class="p127 plot0" onmouseover="ShowDetails(p127)" id="p127">p127</div>
           <div class="p128 plot0" onmouseover="ShowDetails(p128)" id="p128">p128</div>
           <div class="p129 plot0" onmouseover="ShowDetails(p129)" id="p129">p129</div>
           <div class="p130 plot0" onmouseover="ShowDetails(p130)" id="p130">p130</div>
           <div class="p131 plot0" onmouseover="ShowDetails(p131)" id="p131">p131</div>
           <div class="p132 plot0" onmouseover="ShowDetails(p132)" id="p132">p132</div>
           <div class="p133 plot0" onmouseover="ShowDetails(p133)" id="p133">p133</div>
           <div class="p134 plot0" onmouseover="ShowDetails(p134)" id="p134">p134</div>
           <div class="p135 plot0" onmouseover="ShowDetails(p135)" id="p135">p135</div>
           <div class="p136 plot0" onmouseover="ShowDetails(p136)" id="p136">p136</div>
           <div class="p137 plot0" onmouseover="ShowDetails(p137)" id="p137">p137</div>
           <div class="p138 plot0" onmouseover="ShowDetails(p138)" id="p138">p138</div>
           <div class="p139 plot0" onmouseover="ShowDetails(p139)" id="p139">p139</div>
           <div class="p140 plot0" onmouseover="ShowDetails(p140)" id="p140">p140</div>
           <div class="p141 plot0" onmouseover="ShowDetails(p141)" id="p141">p141</div>
           <div class="p142 plot0" onmouseover="ShowDetails(p142)" id="p142">p142</div>
           <div class="p143 plot0" onmouseover="ShowDetails(p143)" id="p143">p143</div>
           <div class="p144 plot0" onmouseover="ShowDetails(p144)" id="p144">p144</div>
           <div class="p145 plot0" onmouseover="ShowDetails(p145)" id="p145">p145</div>
           <div class="p146 plot0" onmouseover="ShowDetails(p146)" id="p146">p146</div>
           <div class="p147 plot0" onmouseover="ShowDetails(p147)" id="p147">p147</div>
           <div class="p148 plot0" onmouseover="ShowDetails(p148)" id="p148">p148</div>
           <div class="p149 plot0" onmouseover="ShowDetails(p149)" id="p149">p149</div>
           <div class="p150 plot0" onmouseover="ShowDetails(p150)" id="p150">p150</div>
           <div class="p151 plot0" onmouseover="ShowDetails(p151)" id="p151">p151</div>
           <div class="p152 plot0" onmouseover="ShowDetails(p152)" id="p152">p152</div>
           <div class="p153 plot0" onmouseover="ShowDetails(p153)" id="p153">p153</div>
           <div class="p154 plot0" onmouseover="ShowDetails(p154)" id="p154">p154</div>
           <div class="p155 plot0" onmouseover="ShowDetails(p155)" id="p155">p155</div>
           <div class="p156 plot0" onmouseover="ShowDetails(p156)" id="p156">p156</div>
           <div class="p157 plot0" onmouseover="ShowDetails(p157)" id="p157">p157</div>
           <div class="p158 plot0" onmouseover="ShowDetails(p158)" id="p158">p158</div>
           <div class="p159 plot0" onmouseover="ShowDetails(p159)" id="p159">p159</div>
           <div class="p160 plot0" onmouseover="ShowDetails(p160)" id="p160">p160</div>
           <div class="p161 plot0" onmouseover="ShowDetails(p161)" id="p161">p161</div>
           <div class="p162 plot0" onmouseover="ShowDetails(p162)" id="p162">p162</div>
           <div class="p163 plot0" onmouseover="ShowDetails(p163)" id="p163">p163</div>
           <div class="p164 plot0" onmouseover="ShowDetails(p164)" id="p164">p164</div>
           <div class="p165 plot0" onmouseover="ShowDetails(p165)" id="p165">p165</div>
           <div class="p166 plot0" onmouseover="ShowDetails(p166)" id="p166">p166</div>
           <div class="p167 plot0" onmouseover="ShowDetails(p167)" id="p167">p167</div>
           <div class="p168 plot0" onmouseover="ShowDetails(p168)" id="p168">p168</div>
           <div class="p169 plot0" onmouseover="ShowDetails(p169)" id="p169">p169</div>
           <div class="p170 plot0" onmouseover="ShowDetails(p170)" id="p170">p170</div>
           <div class="p171 plot0" onmouseover="ShowDetails(p171)" id="p171">p171</div>
           <div class="p172 plot0" onmouseover="ShowDetails(p172)" id="p172">p172</div>
           <div class="p173 plot0" onmouseover="ShowDetails(p173)" id="p173">p173</div>
           <div class="p174 plot0" onmouseover="ShowDetails(p174)" id="p174">p174</div>
           <div class="p175 plot0" onmouseover="ShowDetails(p175)" id="p175">p175</div>
           <div class="p176 plot0" onmouseover="ShowDetails(p176)" id="p176">p176</div>
           <div class="p177 plot0" onmouseover="ShowDetails(p177)" id="p177">p177</div>
           <div class="p178 plot0" onmouseover="ShowDetails(p178)" id="p178">p178</div>
           <div class="p179 plot0" onmouseover="ShowDetails(p179)" id="p179">p179</div>
           <div class="p180 plot0" onmouseover="ShowDetails(p180)" id="p180">p180</div>
           <div class="p181 plot0" onmouseover="ShowDetails(p181)" id="p181">p181</div>
      </div>
    </div>

 <?php include "plot-desc.php"; ?>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script>
</body>

</html>
