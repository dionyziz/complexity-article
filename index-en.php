<?php
    ob_start();
?>
        <h1 id='gentle'>A Gentle Introduction to Algorithm Complexity Analysis</h1>
        Dionysis "dionyziz" Zindros &lt;<a href='mailto:dionyziz@gmail.com'>dionyziz@gmail.com</a>&gt;

        <?= $translations ?>

        <h2 id='intro'>Introduction</h2>
        <p>A lot of programmers that make some of the coolest and most useful software today, such as many of the stuff we see on the Internet or use daily, don't have a theoretical computer science background. They're still pretty awesome and creative programmers and we thank them for what they build.</p>

        <p>However, theoretical computer science has its uses and applications and can turn out to be quite practical. In this article, targeted at programmers who know their art but who don't have any theoretical computer science background, I will present one of the most pragmatic tools of computer science: Big O notation and algorithm complexity analysis. As someone who has worked both in a computer science academic setting and in building production-level software in the industry, this is the tool I have found to be one of the truly useful ones in practice, so I hope after reading this article you can apply it in your own code to make it better. After reading this post, you should be able to understand all the common terms computer scientists use such as "big O", "asymptotic behavior" and "worst-case analysis".</p>

        <p>This text is also targeted at the junior high school and high school students from Greece or anywhere else internationally competing in the <a href='http://en.wikipedia.org/wiki/International_Olympiad_in_Informatics'>International Olympiad in Informatics</a>, an algorithms competition for students, or other similar competitions. As such, it does not have any mathematical prerequisites and will give you the background you need in order to continue studying algorithms with a firmer understanding of the theory behind them. As someone who used to compete in these student competitions, I highly advise you to read through this whole introductory material and try to fully understand it, because it will be necessary as you study algorithms and learn more advanced techniques.</p>

        <p>I believe this text will be helpful for industry programmers who don't have too much experience with theoretical computer science (it is a fact that some of the most inspiring software engineers never went to college). But because it's also for students, it may at times sound a little bit like a textbook. In addition, some of the topics in this text may seem too obvious to you; for example, you may have seen them during your high school years. If you feel you understand them, you can skip them. Other sections go into a bit more depth and become slightly theoretical, as the students competing in this competition need to know more about theoretical algorithms than the average practitioner. But these things are still good to know and not tremendously hard to follow, so it's likely well worth your time. As the original text was targeted at high school students, no mathematical background is required, so anyone with some programming experience (i.e. if you know what recursion is) will be able to follow through without any problem.</p>

        <p>Throughout this article, you will find various pointers that link you to interesting material often outside the scope of the topic under discussion. If you're an industry programmer, it's likely that you're familiar with most of these concepts. If you're a junior student participating in competitions, following those links will give you clues about other areas of computer science or software engineering that you may not have yet explored which you can look at to broaden your interests.</p>

        <p>Big O notation and algorithm complexity analysis is something a lot of industry programmers and junior students alike find hard to understand, fear, or avoid altogether as useless. But it's not as hard or as theoretical as it may seem at first. Algorithm complexity is just a way to formally measure how fast a program or algorithm runs, so it really is quite pragmatic. Let's start by motivating the topic a little bit.</p>

        <div class='sidefigure'>
            <img src='images/halflife2.jpg' alt='A screenshot of an artificial intelligence character in Half-life 2' />
            <label><strong>Figure 1</strong>: Artificial intelligence characters in video games use algorithms to avoid obstacles when navigating in the virtual world</label>
        </div>

        <h2 id='motivation'>Motivation</h2>

        <p>We already know there are tools to measure how fast a program runs. There are programs called <em>profilers</em> which measure running time in milliseconds and can help us optimize our code by spotting bottlenecks. While this is a useful tool, it isn't really relevant to algorithm complexity. Algorithm complexity is something designed to compare two algorithms at the idea level — ignoring low-level details such as the implementation programming language, the hardware the algorithm runs on, or the instruction set of the given CPU. We want to compare algorithms in terms of just what they are: Ideas of how something is computed. Counting milliseconds won't help us in that. It's quite possible that a bad algorithm written in a low-level programming language such as <a href='http://en.wikipedia.org/wiki/Assembly_language'>assembly</a> runs much quicker than a good algorithm written in a high-level programming language such as <a href='http://www.python.org/'>Python</a> or <a href='http://www.ruby-lang.org/en/'>Ruby</a>. So it's time to define what a "better algorithm" really is.</p>

        <p>As algorithms are programs that perform just a computation, and not other things computers often do such as networking tasks or user input and output, complexity analysis allows us to measure how fast a program is when it performs computations. Examples of operations that are purely <em>computational</em> include numerical <a href='http://en.wikipedia.org/wiki/Floating_point'>floating-point operations</a> such as addition and multiplication; searching within a database that fits in RAM for a given value; determining the path an artificial-intelligence character will walk through in a video game so that they only have to walk a short distance within their virtual world (see <strong>Figure 1</strong>); or running a <a href='http://www.regular-expressions.info/'>regular expression</a> pattern match on a string. Clearly, computation is ubiquitous in computer programs.</p>

        <p>Complexity analysis is also a tool that allows us to explain how an algorithm behaves as the input grows larger. If we feed it a different input, how will the algorithm behave? If our algorithm takes 1 second to run for an input of size 1000, how will it behave if I double the input size? Will it run just as fast, half as fast, or four times slower? In practical programming, this is important as it allows us to predict how our algorithm will behave when the input data becomes larger. For example, if we've made an algorithm for a web application that works well with 1000 users and measure its running time, using algorithm complexity analysis we can have a pretty good idea of what will happen once we get 2000 users instead. For algorithmic competitions, complexity analysis gives us insight about how long our code will run for the largest testcases that are used to test our program's correctness. So if we've measured our program's behavior for a small input, we can get a good idea of how it will behave for larger inputs. Let's start by a simple example: Finding the maximum element in an array.</p>

        <h2>Counting instructions</h2>

        <p>In this article, I'll use various programming languages for the examples. However, don't despair if you don't know a particular programming language. Since you know programming, you should be able to read the examples without any problem even if you aren't familiar with the programming language of choice, as they will be simple and I won't use any esoteric language features. If you're a student competing in algorithms competitions, you most likely work with <a href='http://www.cplusplus.com/doc/tutorial/'>C++</a>, so you should have no problem following through. In that case I recommend working on the exercises using C++ for practice.</p>

        <p>The maximum element in an array can be looked up using a simple piece of code such as this piece of <a href='http://www.quirksmode.org/js/intro.html'>Javascript</a> code. Given an input array <var>A</var> of size <var>n</var>:</p>

        <pre name='code' class='brush: js; gutter: false; toolbar: false'>
            var M = A[ 0 ];

            for ( var i = 0; i &lt; n; ++i ) {
                if ( A[ i ] &gt;= M ) {
                    M = A[ i ];
                }
            }
        </pre>

        <p>Now, the first thing we'll do is count how many <em>fundamental instructions</em> this piece of code executes. We will only do this once and it won't be necessary as we develop our theory, so bear with me for a few moments as we do this. As we analyze this piece of code, we want to break it up into simple instructions; things that can be executed by the CPU directly - or close to that. We'll assume our processor can execute the following operations as one instruction each:</p>

        <ul>
            <li>Assigning a value to a variable</li>
            <li>Looking up the value of a particular element in an array</li>
            <li>Comparing two values</li>
            <li>Incrementing a value</li>
            <li>Basic arithmetic operations such as addition and multiplication</li>
        </ul>

        <p>We'll assume branching (the choice between <code>if</code> and <code>else</code> parts of code after the <code>if</code> condition has been evaluated) occurs instantly and won't count these instructions. In the above code, the first line of code is:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            var M = A[ 0 ];
        </pre>

        <p>This requires 2 instructions: One for looking up <var>A[ 0 ]</var> and one for assigning the value to <var>M</var> (we're assuming that n is always at least 1). These two instructions are always required by the algorithm, regardless of the value of <var>n</var>. The <code>for</code> loop initialization code also has to always run. This gives us two more instructions; an assignment and a comparison:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            i = 0;
            i &lt; n;
        </pre>

        <p>These will run before the first <code>for</code> loop iteration. After each <code>for</code> loop iteration, we need two more instructions to run, an increment of <var>i</var> and a comparison to check if we'll stay in the loop:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            ++i;
            i &lt; n;
        </pre>

        <p>So, if we ignore the loop body, the number of instructions this algorithm needs is 4 + 2n. That is, 4 instructions at the beginning of the <code>for</code> loop and 2 instructions at the end of each iteration of which we have <var>n</var>. We can now define a mathematical function f( n ) that, given an <var>n</var>, gives us the number of instructions the algorithm needs. For an empty <code>for</code> body, we have f( n ) = 4 + 2n.</p>

        <h2 id='worst'>Worst-case analysis</h2>

        <p>Now, looking at the <code>for</code> body, we have an array lookup operation and a comparison that happen always:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            if ( A[ i ] &gt;= M ) { ...
        </pre>

        <p>That's two instructions right there. But the <code>if</code> body may run or may not run, depending on what the array values actually are. If it happens to be so that <code>A[ i ] &gt;= M</code>, then we'll run these two additional instructions — an array lookup and an assignment:</p>

        <pre class='brush: jscript; gutter: false; toolbar: false;'>
            M = A[ i ]
        </pre>

        <p>But now we can't define an f( n ) as easily, because our number of instructions doesn't depend solely on <var>n</var> but also on our input. For example, for <code>A = [ 1, 2, 3, 4 ]</code> the algorithm will need more instructions than for <code>A = [ 4, 3, 2, 1 ]</code>. When analyzing algorithms, we often consider the worst-case scenario. What's the worst that can happen for our algorithm? When does our algorithm need the most instructions to complete? In this case, it is when we have an array in increasing order such as <code>A = [ 1, 2, 3, 4 ]</code>. In that case, <var>M</var> needs to be replaced every single time and so that yields the most instructions. Computer scientists have a fancy name for that and they call it <em>worst-case analysis</em>; that's nothing more than just considering the case when we're the most unlucky. So, in the worst case, we have 4 instructions to run within the <code>for</code> body, so we have f( n ) = 4 + 2n + 4n = 6n + 4. This function f, given a problem size n, gives us the number of instructions that would be needed in the worst-case.</p>

        <h2 id='asymptotic'>Asymptotic behavior</h2>

        <p>Given such a function, we have a pretty good idea of how fast an algorithm is. However, as I promised, we won't be needing to go through the tedious task of counting instructions in our program. Besides, the number of actual CPU instructions needed for each programming language statement depends on the compiler of our programming language and on the available CPU instruction set (i.e. whether it's an AMD or an Intel Pentium on your PC, or a MIPS processor on your Playstation 2) and we said we'd be ignoring that. We'll now run our "f" function through a "filter" which will help us get rid of those minor details that computer scientists prefer to ignore.</p>

        <p>In our function, 6n + 4, we have two terms: 6n and 4. In complexity analysis we only care about what happens to the instruction-counting function as the program input (<var>n</var>) grows large. This really goes along with the previous ideas of "worst-case scenario" behavior: We're interested in how our algorithm behaves when treated badly; when it's challenged to do something hard. Notice that this is really useful when comparing algorithms. If an algorithm beats another algorithm for a large input, it's most probably true that the faster algorithm remains faster when given an easier, smaller input. <strong>From the terms that we are considering, we'll drop all the terms that grow slowly and only keep the ones that grow fast as n becomes larger.</strong> Clearly 4 remains a 4 as <var>n</var> grows larger, but 6n grows larger and larger, so it tends to matter more and more for larger problems. Therefore, the first thing we will do is drop the 4 and keep the function as f( n ) = 6n.</p>

        <p>This makes sense if you think about it, as the 4 is simply an "initialization constant". Different programming languages may require a different time to set up. For example, Java needs some time to initialize its <a href='http://en.wikipedia.org/wiki/Java_virtual_machine'>virtual machine</a>. Since we're ignoring programming language differences, it only makes sense to ignore this value.</p>

        <p>The second thing we'll ignore is the constant multiplier in front of <var>n</var>, and so our function will become f( n ) = n. As you can see this simplifies things quite a lot. Again, it makes some sense to drop this multiplicative constant if we think about how different programming languages compile. The "array lookup" statement in one language may compile to different instructions in different programming languages. For example, in C, doing <code>A[ i ]</code> does not include a check that <var>i</var> is within the declared array size, while in <a href='http://en.wikipedia.org/wiki/Pascal_(programming_language)'>Pascal</a> it does. So, the following Pascal code:</p>

        <pre class='brush: delphi; gutter: false; toolbar: false;'>
            M := A[ i ]
        </pre>

        <p>Is the equivalent of the following in C:</p>

        <pre class='brush: c; gutter: false; toolbar: false;'>
            if ( i &gt;= 0 &amp;&amp; i &lt; n ) {
                M = A[ i ];
            }
        </pre>

        <p>So it's reasonable to expect that different programming languages will yield different factors when we count their instructions. In our example in which we are using a dumb compiler for Pascal that is oblivious of possible optimizations, Pascal requires 3 instructions for each array access instead of the 1 instruction C requires. Dropping this factor goes along the lines of ignoring the differences between particular programming languages and compilers and only analyzing the idea of the algorithm itself.</p>

        <p>This filter of "dropping all factors" and of "keeping the largest growing term" as described above is what we call <em>asymptotic behavior</em>. So the asymptotic behavior of f( n ) = 2n + 8 is described by the function f( n ) = n. Mathematically speaking, what we're saying here is that we're interested in the limit of function f as <var>n</var> tends to infinity; but if you don't understand what that phrase formally means, don't worry, because this is all you need to know. (On a side note, in a strict mathematical setting, we would not be able to drop the constants in the limit; but for computer science purposes, we want to do that for the reasons described above.) Let's work a couple of examples to familiarize ourselves with the concept.</p>

        <div class='right sidefigure'>
            <img src='images/cubic-vs-linear.png' alt='The cubic function, in blue, overcomes the linear function, in red, after n = 45' />
            <label><strong>Figure 2</strong>: The n<sup>3</sup> function, drawn in blue, becomes larger than the 1999n function, drawn in red, after n = 45. After that point it remains larger for ever.</label>
        </div>

        <p>Let us find the asymptotic behavior of the following example functions by dropping the constant factors and by keeping the terms that grow the fastest.</p>

        <ol>
            <li><p>f( n ) = 5n + 12 gives f( n ) = n.</p>
                <p>By using the exact same reasoning as above.</p></li>

            <li><p>f( n ) = 109 gives f( n ) = 1.</p>
                <p>We're dropping the multiplier 109 * 1, but we still have to put a 1 here to indicate that this function has a non-zero value.</p></li>

            <li><p>f( n ) = n<sup>2</sup> + 3n + 112 gives f( n ) = n<sup>2</sup></p>
                <p>Here, n<sup>2</sup> grows larger than 3n for sufficiently large n, so we're keeping that.</p></li>

            <li><p>f( n ) = n<sup>3</sup> + 1999n + 1337 gives f( n ) = n<sup>3</sup></p>
                <p>Even though the factor in front of n is quite large, we can still find a large enough <var>n</var> so that n<sup>3</sup> is bigger than 1999n. As we're interested in the behavior for very large values of <var>n</var>, we only keep n<sup>3</sup> (See <strong>Figure 2</strong>).</p></li>

            <li><p>f( n ) = n + <img alt='sqrt( n )' src='images/sqrtn.png' /> gives f( n ) = n</p>
                <p>This is so because n grows faster than <img alt='sqrt( n )' src='images/sqrtn.png' /> as we increase <var>n</var>.</p></li>
        </ol>

        <p>You can try out the following examples on your own:</p>
        <div class='exercise'>
            <h3>Exercise 1</h3>
            <ol>
                <li>f( n ) = n<sup>6</sup> + 3n</li>
                <li>f( n ) = 2<sup>n</sup> + 12</li>
                <li>f( n ) = 3<sup>n</sup> + 2<sup>n</sup></li>
                <li>f( n ) = n<sup>n</sup> + n</li>
            </ol>
            <p>(Write down your results; the solution is given below)</p>

            <p>If you're having trouble with one of the above, plug in some large <var>n</var> and see which term is bigger. Pretty straightforward, huh?</p>
        </div>

        <h2 id='complexity'>Complexity</h2>

        <p>So what this is telling us is that since we can drop all these decorative constants, it's pretty easy to tell the asymptotic behavior of the instruction-counting function of a program. In fact, any program that doesn't have any loops will have f( n ) = 1, since the number of instructions it needs is just a constant (unless it uses recursion; see below). Any program with a single loop which goes from 1 to <var>n</var> will have f( n ) = n, since it will do a constant number of instructions before the loop, a constant number of instructions after the loop, and a constant number of instructions within the loop which all run <var>n</var> times.</p>

        <p>This should now be much easier and less tedious than counting individual instructions, so let's take a look at a couple of examples to get familiar with this. The following <a href='http://php.net/'>PHP</a> program checks to see if a particular value exists within an array <var>A</var> of size <var>n</var>:</p>

        <pre class='brush: php; gutter: false; toolbar: false;'>
            &lt;?php
                $exists = false;
                for ( $i = 0; $i &lt; n; ++$i ) {
                    if ( $A[ $i ] == $value ) {
                        $exists = true;
                        break;
                    }
                }
            ?&gt;
        </pre>

        <p>This method of searching for a value within an array is called <em>linear search</em>. This is a reasonable name, as this program has f( n ) = n (we'll define exactly what "linear" means in the next section). You may notice that there's a "break" statement here that may make the program terminate sooner, even after a single iteration. But recall that we're interested in the worst-case scenario, which for this program is for the array <var>A</var> to not contain the value. So we still have f( n ) = n.</p>

        <div class='exercise'>
            <h3>Exercise 2</h3>

            <p>Systematically analyze the number of instructions the above PHP program needs with respect to <var>n</var> in the worst-case to find f( n ), similarly to how we analyzed our first Javascript program. Then verify that, asymptotically, we have f( n ) = n.</p>
        </div>

        <p>Let's look at a Python program which adds two array elements together to produce a sum which it stores in another variable:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
            v = a[ 0 ] + a[ 1 ]
        </pre>

        <p>Here we have a constant number of instructions, so we have f( n ) = 1.</p>

        <p>The following program in C++ checks to see if a vector (a fancy array) named <var>A</var> of size <var>n</var> contains the same two values anywhere within it:</p>

        <pre class='brush: cpp; gutter: false; toolbar: false;'>
            bool duplicate = false;
            for ( int i = 0; i &lt; n; ++i ) {
                for ( int j = 0; j &lt; n; ++j ) {
                    if ( i != j &amp;&amp; A[ i ] == A[ j ] ) {
                        duplicate = true;
                        break;
                    }
                }
                if ( duplicate ) {
                    break;
                }
            }
        </pre>

        <p>As here we have two nested loops within each other, we'll have an asymptotic behavior described by f( n ) = n<sup>2</sup>.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: Simple programs can be analyzed by counting the nested loops of the program. A single loop over n items yields f( n ) = n. A loop within a loop yields f( n ) = n<sup>2</sup>. A loop within a loop within a loop yields f( n ) = n<sup>3</sup>.</p>
        </div>

        <p>If we have a program that calls a function within a loop and we know the number of instructions the called function performs, it's easy to determine the number of instructions of the whole program. Indeed, let's take a look at this C example:</p>

        <pre class='brush: c; gutter: false; toolbar: false;'>
            int i;
            for ( i = 0; i &lt; n; ++i ) {
                f( n );
            }
        </pre>

        <p>If we know that <code>f( n )</code> is a function that performs exactly <var>n</var> instructions, we can then know that the number of instructions of the whole program is asymptotically n<sup>2</sup>, as the function is called exactly <var>n</var> times.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: Given a series of for loops that are sequential, the slowest of them determines the asymptotic behavior of the program. Two nested loops followed by a single loop is asymptotically the same as the nested loops alone, because the nested loops <em>dominate</em> the simple loop.</p>
        </div>

        <p>Now, let's switch over to the fancy notation that computer scientists use. When we've figured out the exact such f asymptotically, we'll say that our program is Θ( f( n ) ). For example, the above programs are Θ( 1 ), Θ( n<sup>2</sup> ) and Θ( n<sup>2</sup> ) respectively. Θ( n ) is pronounced "theta of n". Sometimes we say that f( n ), the original function counting the instructions including the constants, is Θ( something ). For example, we may say that f( n ) = 2n is a function that is Θ( n ) — nothing new here. We can also write 2n ∈ Θ( n ), which is pronounced as "two n is theta of n". Don't get confused about this notation: All it's saying is that if we've counted the number of instructions a program needs and those are 2n, then the asymptotic behavior of our algorithm is described by n, which we found by dropping the constants. Given this notation, the following are some true mathematical statements:</p>
        <ol>
            <li>n<sup>6</sup> + 3n ∈ Θ( n<sup>6</sup> )</li>
            <li>2<sup>n</sup> + 12 ∈ Θ( 2<sup>n</sup> )</li>
            <li>3<sup>n</sup> + 2<sup>n</sup> ∈ Θ( 3<sup>n</sup> )</li>
            <li>n<sup>n</sup> + n ∈ Θ( n<sup>n</sup> )</li>
        </ol>

        <p>By the way, if you solved Exercise 1 from above, these are exactly the answers you should have found.</p>

        <p><strong>We call this function, i.e. what we put within Θ( here ), the <em>time complexity</em> or just <em>complexity</em> of our algorithm.</strong> So an algorithm with Θ( n ) is of complexity n. We also have special names for Θ( 1 ), Θ( n ), Θ( n<sup>2</sup> ) and Θ( log( n ) ) because they occur very often. We say that a Θ( 1 ) algorithm is a <em>constant-time algorithm</em>, Θ( n ) is <em>linear</em>, Θ( n<sup>2</sup> ) is <em>quadratic</em> and Θ( log( n ) ) is <em>logarithmic</em> (don't worry if you don't know what logarithms are yet – we'll get to that in a minute).</p>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: Programs with a bigger Θ run slower than programs with a smaller Θ.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/hidden-surface.jpg' alt='An example of surfaces hidden in a video game' />
            <label><strong>Figure 3</strong>: A player that is located in the yellow dot will not see the shadowed areas. Splitting the world in small fragments and sorting them by their distance to the player is one way to solve the visibility problem.</label>
        </div>

        <h2 id='big-o'>Big-O notation</h2>

        <p>Now, it's sometimes true that it will be hard to figure out exactly the behavior of an algorithm in this fashion as we did above, especially for more complex examples. However, we will be able to say that the behavior of our algorithm will never exceed a certain bound. This will make life easier for us, as we won't have to specify exactly how fast our algorithm runs, even when ignoring constants the way we did before. All we'll have to do is find a certain bound. This is explained easily with an example.</p>

        <p>A famous problem computer scientists use for teaching algorithms is the <em>sorting problem</em>. In the sorting problem, an array <var>A</var> of size <var>n</var> is given (sounds familiar?) and we are asked to write a program that sorts this array. This problem is interesting because it is a pragmatic problem in real systems. For example, a file explorer needs to sort the files it displays by name so that the user can navigate them with ease. Or, as another example, a video game may need to sort the 3D objects displayed in the world based on their distance from the player's eye inside the virtual world in order to determine what is visible and what isn't, something called the <a href='http://en.wikipedia.org/wiki/Hidden_surface_determination'>Visibility Problem</a> (see <strong>Figure 3</strong>). The objects that turn out to be closest to the player are those visible, while those that are further may get hidden by the objects in front of them. Sorting is also interesting because there are many algorithms to solve it, some of which are worse than others. It's also an easy problem to define and to explain. So let's write a piece of code that sorts an array.</p>

        <p>Here is an inefficient way to implement sorting an array in Ruby. (Of course, Ruby supports sorting arrays using build-in functions which you should use instead, and which are certainly faster than what we'll see here. But this is here for illustration purposes.)</p>

        <div class='leftofimage'>
            <pre class='brush: ruby; gutter: false; toolbar: false;'>
                b = []
                n.times do
                    m = a[ 0 ]
                    mi = 0
                    a.each_with_index do |element, i|
                        if element &lt; m
                            m = element
                            mi = i
                        end
                    end
                    a.delete_at( mi )
                    b &lt;&lt; m
                end
            </pre>
        </div>

        <p>This method is called <a href='http://en.wikipedia.org/wiki/Selection_sort'>selection sort</a>. It finds the minimum of our array (the array is denoted <var>a</var> above, while the minimum value is denoted <var>m</var> and <var>mi</var> is its index), puts it at the end of a new array (in our case <var>b</var>), and removes it from the original array. Then it finds the minimum between the remaining values of our original array, appends that to our new array so that it now contains two elements, and removes it from our original array. It continues this process until all items have been removed from the original and have been inserted into the new array, which means that the array has been sorted. In this example, we can see that we have two nested loops. The outer loop runs <var>n</var> times, and the inner loop runs once for each element of the array <var>a</var>. While the array <var>a</var> initially has <var>n</var> items, we remove one array item in each iteration. So the inner loop repeats <var>n</var> times during the first iteration of the outer loop, then <code>n - 1</code> times, then <code>n - 2</code> times and so forth, until the last iteration of the outer loop during which it only runs once.</p>

        <p>It's a little harder to evaluate the complexity of this program, as we'd have to figure out the sum 1 + 2 + ... + (n - 1) + n. But we can for sure find an "upper bound" for it. That is, we can alter our program (you can do that in your mind, not in the actual code) to make it <strong>worse</strong> than it is and then find the complexity of that new program that we derived. If we can find the complexity of the worse program that we've constructed, then we know that our original program is at most that bad, or maybe better. That way, if we find out a pretty good complexity for our altered program, which is worse than our original, we can know that our original program will have a pretty good complexity too – either as good as our altered program or even better.</p>

        <p>Let's now think of the way to edit this example program to make it easier to figure out its complexity. But let's keep in mind that we can only make it worse, i.e. make it take up more instructions, so that our estimate is meaningful for our original program. Clearly we can alter the inner loop of the program to always repeat exactly <var>n</var> times instead of a varying number of times. Some of these repetitions will be useless, but it will help us analyze the complexity of the resulting algorithm. If we make this simple change, then the new algorithm that we've constructed is clearly Θ( n<sup>2</sup> ), because we have two nested loops where each repeats exactly <var>n</var> times. If that is so, we say that the original algorithm is O( n<sup>2</sup> ). O( n<sup>2</sup> ) is pronounced "big oh of n squared". What this says is that our program is asymptotically no worse than n<sup>2</sup>. It may even be better than that, or it may be the same as that. By the way, if our program is indeed Θ( n<sup>2</sup> ), we can still say that it's O( n<sup>2</sup> ). To help you realize that, imagine altering the original program in a way that doesn't change it much, but still makes it a little worse, such as adding a meaningless instruction at the beginning of the program. Doing this will alter the instruction-counting function by a simple constant, which is ignored when it comes to asymptotic behavior. So a program that is Θ( n<sup>2</sup> ) is also O( n<sup>2</sup> ).</p>

        <p>But a program that is O( n<sup>2</sup> ) may not be Θ( n<sup>2</sup> ). For example, any program that is Θ( n ) is also O( n<sup>2</sup> ) in addition to being O( n ). If we imagine the that a Θ( n ) program is a simple <code>for</code> loop that repeats <var>n</var> times, we can make it worse by wrapping it in another <code>for</code> loop which repeats <var>n</var> times as well, thus producing a program with f( n ) = n<sup>2</sup>. To generalize this, any program that is Θ( <var>a</var> ) is O( <var>b</var> ) when <var>b</var> is worse than <var>a</var>. Notice that our alteration to the program doesn't need to give us a program that is actually meaningful or equivalent to our original program. It only needs to perform more instructions than the original for a given <var>n</var>. All we're using it for is counting instructions, not actually solving our problem.</p>

        <p>So, saying that our program is O( n<sup>2</sup> ) is being on the safe side: We've analyzed our algorithm, and we've found that it's never worse than n<sup>2</sup>. But it could be that it's in fact n<sup>2</sup>. This gives us a good estimate of how fast our program runs. Let's go through a few examples to help you familiarize yourself with this new notation.</p>

        <div class='exercise'>
            <h3>Exercise 3</h3>

            <p>Find out which of the following are true:</p>
            <ol>
                <li>A Θ( n ) algorithm is O( n )</li>
                <li>A Θ( n ) algorithm is O( n<sup>2</sup> )</li>
                <li>A Θ( n<sup>2</sup> ) algorithm is O( n<sup>3</sup> )</li>
                <li>A Θ( n ) algorithm is O( 1 )</li>
                <li>A O( 1 ) algorithm is Θ( 1 )</li>
                <li>A O( n ) algorithm is Θ( 1 )</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solution</h3>

            <ol>
                <li>We know that this is true as our original program was Θ( n ). We can achieve O( n ) without altering our program at all.</li>
                <li>As n<sup>2</sup> is worse than n, this is true.</li>
                <li>As n<sup>3</sup> is worse than n<sup>2</sup>, this is true.</li>
                <li>As 1 is not worse than n, this is false. If a program takes <var>n</var> instructions asymptotically (a linear number of instructions), we can't make it worse and have it take only 1 instruction asymptotically (a constant number of instructions).</li>
                <li>This is true as the two complexities are the same.</li>
                <li>This may or may not be true depending on the algorithm. In the general case it's false. If an algorithm is Θ( 1 ), then it certainly is O( n ). But if it's O( n ) then it may not be Θ( 1 ). For example, a Θ( n ) algorithm is O( n ) but not Θ( 1 ).</li>
            </ol>
        </div>

        <div class='exercise'>
            <h3>Exercise 4</h3>

            <p>Use an arithmetic progression sum to prove that the above program is not only O( n<sup>2</sup> ) but also Θ( n<sup>2</sup> ). If you don't know what an arithmetic progression is, look it up on <a href='http://en.wikipedia.org/wiki/1_%2B_2_%2B_3_%2B_4_%2B_%E2%80%A6'>Wikipedia</a> – it's easy.</p>
        </div>

        <p>Because the O-complexity of an algorithm gives an <em>upper bound</em> for the actual complexity of an algorithm, while Θ gives the actual complexity of an algorithm, we sometimes say that the Θ gives us a <em>tight bound</em>. If we know that we've found a complexity bound that is not tight, we can also use a lower-case o to denote that. For example, if an algorithm is Θ( n ), then its tight complexity is n. Then this algorithm is both O( n ) and O( n<sup>2</sup> ). As the algorithm is Θ( n ), the O( n ) bound is a tight one. But the O( n<sup>2</sup> ) bound is not tight, and so we can write that the algorithm is o( n<sup>2</sup> ), which is pronounced "small o of n squared" to illustrate that we know our bound is not tight. It's better if we can find tight bounds for our algorithms, as these give us more information about how our algorithm behaves, but it's not always easy to do.</p>

        <div class='exercise'>
            <h3>Exercise 5</h3>

            <p>Determine which of the following bounds are tight bounds and which are not tight bounds. Check to see if any bounds may be wrong. Use o( notation ) to illustrate the bounds that are not tight.</p>

            <ol>
                <li>A Θ( n ) algorithm for which we found a O( n ) upper bound.</li>
                <li>A Θ( n<sup>2</sup> ) algorithm for which we found a O( n<sup>3</sup> ) upper bound.</li>
                <li>A Θ( 1 ) algorithm for which we found an O( n ) upper bound.</li>
                <li>A Θ( n ) algorithm for which we found an O( 1 ) upper bound.</li>
                <li>A Θ( n ) algorithm for which we found an O( 2n ) upper bound.</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solution</h3>

            <ol>
                <li>In this case, the Θ complexity and the O complexity are the same, so the bound is tight.</li>
                <li>Here we see that the O complexity is of a larger scale than the Θ complexity so this bound is not tight. Indeed, a bound of O( n<sup>2</sup> ) would be a tight one. So we can write that the algorithm is o( n<sup>3</sup> ).</li>
                <li>Again we see that the O complexity is of a larger scale than the Θ complexity so we have a bound that isn't tight. A bound of O( 1 ) would be a tight one. So we can point out that the O( n ) bound is not tight by writing it as o( n ).</li>
                <li>We must have made a mistake in calculating this bound, as it's wrong. It's impossible for a Θ( n ) algorithm to have an upper bound of O( 1 ), as n is a larger complexity than 1. Remember that O gives an upper bound.</li>
                <li>This may seem like a bound that is not tight, but this is not actually true. This bound is in fact tight. Recall that the asymptotic behavior of 2n and n are the same, and that O and Θ are only concerned with asymptotic behavior. So we have that O( 2n ) = O( n ) and therefore this bound is tight as the complexity is the same as the Θ.</li>
            </ol>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: It's easier to figure out the O-complexity of an algorithm than its Θ-complexity.</p>
        </div>

        <p>You may be getting a little overwhelmed with all this new notation by now, but let's introduce just two more symbols before we move on to a few examples. These are easy now that you know Θ, O and o, and we won't use them much later in this article, but it's good to know them now that we're at it. In the example above, we modified our program to make it worse (i.e. taking more instructions and therefore more time) and created the O notation. O is meaningful because it tells us that our program will never be slower than a specific bound, and so it provides valuable information so that we can argue that our program is good enough. If we do the opposite and modify our program to make it <strong>better</strong> and find out the complexity of the resulting program, we use the notation Ω. Ω therefore gives us a complexity that we know our program won't be better than. This is useful if we want to prove that a program runs slowly or an algorithm is a bad one. This can be useful to argue that an algorithm is too slow to use in a particular case. For example, saying that an algorithm is Ω( n<sup>3</sup> ) means that the algorithm isn't better than n<sup>3</sup>. It might be Θ( n<sup>3</sup> ), as bad as Θ( n<sup>4</sup> ) or even worse, but we know it's at least somewhat bad. So Ω gives us a <em>lower bound</em> for the complexity of our algorithm. Similarly to ο, we can write ω if we know that our bound isn't tight. For example, a Θ( n<sup>3</sup> ) algorithm is ο( n<sup>4</sup> ) and ω( n<sup>2</sup> ). Ω( n ) is pronounced "big omega of n", while ω( n ) is pronounced "small omega of n".</p>


        <div class='exercise'>
            <h3>Exercise 6</h3>

            <p>For the following Θ complexities write down a tight and a non-tight O bound, and a tight and non-tight Ω bound of your choice, providing they exist.</p>
            <ol>
                <li>Θ( 1 )</li>
                <li>Θ( <img alt='sqrt( n )' src='images/sqrtn.png' /> )</li>
                <li>Θ( n )</li>
                <li>Θ( n<sup>2</sup> )</li>
                <li>Θ( n<sup>3</sup> )</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solution</h3>

            <p>This is a straight-forward application of the definitions above.</p>

            <ol>
                <li>The tight bounds will be O( 1 ) and Ω( 1 ). A non-tight O-bound would be O( n ). Recall that O gives us an upper bound. As n is of larger scale than 1 this is a non-tight bound and we can write it as o( n ) as well. But we cannot find a non-tight bound for Ω, as we can't get lower than 1 for these functions. So we'll have to do with the tight bound.</li>
                <li>The tight bounds will have to be the same as the Θ complexity, so they are O( <img alt='sqrt( n )' src='images/sqrtn.png' /> ) and Ω( <img alt='sqrt( n )' src='images/sqrtn.png' /> ) respectively. For non-tight bounds we can have O( n ), as n is larger than <img alt='sqrt( n )' src='images/sqrtn.png' /> and so it is an upper bound for <img alt='sqrt( n )' src='images/sqrtn.png' />. As we know this is a non-tight upper bound, we can also write it as o( n ). For a lower bound that is not tight, we can simply use Ω( 1 ). As we know that this bound is not tight, we can also write it as ω( 1 ).</li>
                <li>The tight bounds are O( n ) and Ω( n ). Two non-tight bounds could be ω( 1 ) and o( n<sup>3</sup> ). These are in fact pretty bad bounds, as they are far from the original complexities, but they are still valid using our definitions.</li>
                <li>The tight bounds are O( n<sup>2</sup> ) and Ω( n<sup>2</sup> ). For non-tight bounds we could again use ω( 1 ) and o( n<sup>3</sup> ) as in our previous example.</li>
                <li>The tight bounds are O( n<sup>3</sup> ) and Ω( n<sup>3</sup> ) respectively. Two non-tight bounds could be ω( <img alt='sqrt( n )' src='images/sqrtn.png' /> n<sup>2</sup> ) and o( <img alt='sqrt( n )' src='images/sqrtn.png' /> n<sup>3</sup> ). Although these bounds are not tight, they're better than the ones we gave above.</li>
            </ol>
        </div>

        <p>The reason we use O and Ω instead of Θ even though O and Ω can also give tight bounds is that we may not be able to tell if a bound we've found is tight, or we may just not want to go through the process of scrutinizing it so much.</p>

        <p>If you don't fully remember all the different symbols and their uses, don't worry about it too much right now. You can always come back and look them up. The most important symbols are O and Θ.</p>

        <p>Also note that although Ω gives us a lower-bound behavior for our function (i.e. we've improved our program and made it perform less instructions) we're still referring to a "worst-case" analysis. This is because we're feeding our program the worst possible input for a given n and analyzing its behavior under this assumption.</p>

        <p>The following table indicates the symbols we just introduced and their correspondence with the usual mathematical symbols of comparisons that we use for numbers. The reason we don't use the usual symbols here and use Greek letters instead is to point out that we're doing an asymptotic behavior comparison, not just a simple comparison.</p>

        <div class='figure'>
            <table>
                <thead>
                    <tr>
                        <th>Asymptotic comparison operator</th>
                        <th>Numeric comparison operator</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Our algorithm is <strong>o</strong>( something )</td>
                        <td>A number is <strong>&lt;</strong> something</td>
                    </tr>
                    <tr>
                        <td>Our algorithm is <strong>O</strong>( something )</td>
                        <td>A number is <strong>≤</strong> something</td>
                    </tr>
                    <tr>
                        <td>Our algorithm is <strong>Θ</strong>( something )</td>
                        <td>A number is <strong>=</strong> something</td>
                    </tr>
                    <tr>
                        <td>Our algorithm is <strong>Ω</strong>( something )</td>
                        <td>A number is <strong>≥</strong> something</td>
                    </tr>
                    <tr>
                        <td>Our algorithm is <strong>ω</strong>( something )</td>
                        <td>A number is <strong>></strong> something</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: While all the symbols O, o, Ω, ω and Θ are useful at times, O is the one used more commonly, as it's easier to determine than Θ and more practically useful than Ω.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/log-vs-linear.png' alt='The log function is much lower than the square root function, which, in turn, is much lower than the linear function even for small n' />
            <label><strong>Figure 4</strong>: A comparison of the functions n, <img alt='sqrt( n )' src='images/sqrtn.png' />, and log( n ). Function n, the linear function, drawn in green at the top, grows much faster than the square root function, drawn in red in the middle, which, in turn, grows much faster than the log( n ) function drawn in blue at the bottom of this plot. Even for small n such as n = 100, the difference is quite pronounced.</label>
        </div>

        <h2 id='logarithms'>Logarithms</h2>

        <p>If you know what logarithms are, feel free to skip this section. As a lot of people are unfamiliar with logarithms, or just haven't used them much recently and don't remember them, this section is here as an introduction for them. This text is also for younger students that haven't seen logarithms at school yet. Logarithms are important because they occur a lot when analyzing complexity. A <em>logarithm</em> is an operation applied to a number that makes it quite smaller – much like a square root of a number. So if there's one thing you want to remember about logarithms is that they take a number and make it much smaller than the original (See <strong>Figure 4</strong>). Now, in the same way that square roots are the inverse operation of squaring something, logarithms are the inverse operation of exponentiating something. This isn't as hard as it sounds. It's better explained with an example. Consider the equation:</p>

        <p>2<sup>x</sup> = 1024</p>

        <p>We now wish to solve this equation for <var>x</var>. So we ask ourselves: What is the number to which we must raise the base 2 so that we get 1024? That number is 10. Indeed, we have 2<sup>10</sup> = 1024, which is easy to verify. Logarithms help us denote this problem using new notation. In this case, 10 is the logarithm of 1024 and we write this as log( 1024 ) and we read it as "the logarithm of 1024". Because we're using 2 as a base, these logarithms are called base 2 logarithms. There are logarithms in other bases, but we'll only use base 2 logarithms in this article. If you're a student competing in international competitions and you don't know about logarithms, I highly recommend that you <a href='http://tutorial.math.lamar.edu/Classes/Alg/LogFunctions.aspx'>practice your logarithms</a> after completing this article. In computer science, base 2 logarithms are much more common than any other types of logarithms. This is because we often only have two different entities: 0 and 1. We also tend to cut down one big problem into halves, of which there are always two. So you only need to know about base-2 logarithms to continue with this article.</p>

        <div class='exercise'>
            <h3>Exercise 7</h3>

            <p>Solve the equations below. Denote what logarithm you're finding in each case. Use only logarithms base 2.</p>
            <ol>
                <li>2<sup>x</sup> = 64</li>
                <li>(2<sup>2</sup>)<sup>x</sup> = 64</li>
                <li>4<sup>x</sup> = 4</li>
                <li>2<sup>x</sup> = 1</li>
                <li>2<sup>x</sup> + 2<sup>x</sup> = 32</li>
                <li>(2<sup>x</sup>) * (2<sup>x</sup>) = 64</li>
            </ol>
        </div>

        <div class='exercise solution'>
            <h3>Solution</h3>

            <p>There is nothing more to this than applying the ideas defined above.</p>
            <ol>
                <li>By trial and error we can find that x = 6 and so log( 64 ) = 6.</li>
                <li>Here we notice that (2<sup>2</sup>)<sup>x</sup>, by the properties of exponents, can be written as 2<sup>2x</sup>. So we have that 2x = 6 because log( 64 ) = 6 from the previous result and therefore x = 3.</li>
                <li>Using our knowledge from the previous equation, we can write 4 as 2<sup>2</sup> and so our equation becomes (2<sup>2</sup>)<sup>x</sup> = 4 which is the same as 2<sup>2x</sup> = 4. Then we notice that log( 4 ) = 2 because 2<sup>2</sup> = 4 and therefore we have that 2x = 2. So x = 1. This is readily observed from the original equation, as using an exponent of 1 yields the base as a result.</li>
                <li>Recall that an exponent of 0 yields a result of 1. So we have log( 1 ) = 0 as 2<sup>0</sup> = 1, and so x = 0.</li>
                <li>Here we have a sum and so we can't take the logarithm directly. However we notice that 2<sup>x</sup> + 2<sup>x</sup> is the same as 2 * (2<sup>x</sup>). So we've multiplied in yet another two, and therefore this is the same as 2<sup>x + 1</sup> and now all we have to do is solve the equation 2<sup>x + 1</sup> = 32. We find that log( 32 ) = 5 and so x + 1 = 5 and therefore x = 4.</li>
                <li>We're multiplying together two powers of 2, and so we can join them by noticing that (2<sup>x</sup>) * (2<sup>x</sup>) is the same as 2<sup>2x</sup>. Then all we need to do is to solve the equation 2<sup>2x</sup> = 64 which we already solved above and so x = 3.</li>
            </ol>
        </div>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: For competition algorithms implemented in C++, once you've analyzed your complexity, you can get a rough estimate of how fast your program will run by expecting it to perform about 1,000,000 operations per second, where the operations you count are given by the asymptotic behavior function describing your algorithm. For example, a Θ( n ) algorithm takes about a second to process the input for n = 1,000,000.</p>
        </div>

        <div class='right sidefigure'>
            <img src='images/factorial-recursion.png' alt='factorial( 5 ) -&gt; factorial( 4 ) -&gt; factorial( 3 ) -&gt; factorial( 2 ) -&gt; factorial( 1 )' />
            <label><strong>Figure 5</strong>: The recursion performed by the factorial function.</label>
        </div>

        <h2 id='recursion'>Recursive complexity</h2>

        <p>Let's now take a look at a recursive function. A <em>recursive function</em> is a function that calls itself. Can we analyze its complexity? The following function, written in Python, evaluates the <a href='http://en.wikipedia.org/wiki/Factorial'>factorial</a> of a given number. The factorial of a positive integer number is found by multiplying it with all the previous positive integers together. For example, the factorial of 5 is 5 * 4 * 3 * 2 * 1. We denote that "5!" and pronounce it "five factorial" (some people prefer to pronounce it by screaming it out aloud like "FIVE!!!")</p>

        <div class='leftofimage'>
            <pre class='brush: python; gutter: false; toolbar: false;'>
                def factorial( n ):
                    if n == 1:
                        return 1
                    return n * factorial( n - 1 )
            </pre>
        </div>

        <p>Let us analyze the complexity of this function. This function doesn't have any loops in it, but its complexity isn't constant either. What we need to do to find out its complexity is again to go about counting instructions. Clearly, if we pass some <var>n</var> to this function, it will execute itself <var>n</var> times. If you're unsure about that, run it "by hand" now for n = 5 to validate that it actually works. For example, for n = 5, it will execute 5 times, as it will keep decreasing n by 1 in each call. We can see therefore that this function is then Θ( n ).</p>

        <p>If you're unsure about this fact, remember that you can always find the exact complexity by counting instructions. If you wish, you can now try to count the actual instructions performed by this function to find a function f( n ) and see that it's indeed linear (recall that linear means Θ( n )).</p>

        <p>See <strong>Figure 5</strong> for a diagram to help you understand the recursions performed when factorial( 5 ) is called.</p>

        <p>This should clear up why this function is of linear complexity.</p>

        <div class='right sidefigure'>
            <img src='images/binary-search.png' alt='Binary searching in an array' />
            <label><strong>Figure 6</strong>: The recursion performed by binary search. The A argument for each call is highlighted in black. The recursion continues until the array examined consists of only one element. Courtesy of Luke Francl.</label>
        </div>

        <h2 id='logcomplexity'>Logarithmic complexity</h2>

        <p>One famous problem in computer science is that of searching for a value within an array. We solved this problem earlier for the general case. This problem becomes interesting if we have an array which is sorted and we want to find a given value within it. One method to do that is called <em>binary search</em>. We look at the middle element of our array: If we find it there, we're done. Otherwise, if the value we find there is bigger than the value we're looking for, we know that our element will be on the left part of the array. Otherwise, we know it'll be on the right part of the array. We can keep cutting these smaller arrays in halves until we have a single element to look at. Here's the method using pseudocode:</p>

        <div class='leftofimage'>
            <pre class='brush: python; gutter: false; toolbar: false;'>
                def binarySearch( A, n, value ):
                    if n = 1:
                        if A[ 0 ] = value:
                            return true
                        else:
                            return false
                    if value &lt; A[ n / 2 ]:
                        return binarySearch( A[ 0...( n / 2 - 1 ) ], n / 2 - 1, value )
                    else if value &gt; A[ n / 2 ]:
                        return binarySearch( A[ ( n / 2 + 1 )...n ], n / 2 - 1, value )
                    else:
                        return true
            </pre>
        </div>

        <p>This pseudocode is a simplification of the actual implementation. In practice, this method is easier described than implemented, as the programmer needs to take care of some implementation issues. There are off-by-one errors and the division by 2 may not always produce an integer value and so it's necessary to floor() or ceil() the value. But we can assume for our purposes that it will always succeed, and we'll assume our actual implementation in fact takes care of the off-by-one errors, as we only want to analyze the complexity of this method. If you've never implemented binary search before, you may want to do this in your favourite programming language. It's a truly enlightening endeavor.</p>

        <p>See <strong>Figure 6</strong> to help you understand the way binary search operates.</p>

        <p>If you're unsure that this method actually works, take a moment now to run it by hand in a simple example and convince yourself that it actually works.</p>

        <p>Let us now attempt to analyze this algorithm. Again, we have a recursive algorithm in this case. Let's assume, for simplicity, that the array is always cut in exactly a half, ignoring just now the + 1 and - 1 part in the recursive call. By now you should be convinced that a little change such as ignoring + 1 and - 1 won't affect our complexity results. This is a fact that we would normally have to prove if we wanted to be prudent from a mathematical point of view, but practically it is intuitively obvious. Let's assume that our array has a size that is an exact power of 2, for simplicity. Again this assumption doesn't change the final results of our complexity that we will arrive at. The worst-case scenario for this problem would happen when the value we're looking for does not occur in our array at all. In that case, we'd start with an array of size n in the first call of the recursion, then get an array of size n / 2 in the next call. Then we'll get an array of size n / 4 in the next recursive call, followed by an array of size n / 8 and so forth. In general, our array is split in half in every call, until we reach 1. So, let's write the number of elements in our array for every call:</p>
        <ol class='hide-nums'>
            <li>0<sup>th</sup> iteration: n</li>
            <li>1<sup>st</sup> iteration: n / 2</li>
            <li>2<sup>nd</sup> iteration: n / 4</li>
            <li>3<sup>rd</sup> iteration: n / 8</li>
            <li>...</li>
            <li>i<sup>th</sup> iteration: n / 2<sup>i</sup></li>
            <li>...</li>
            <li>last iteration: 1</li>
        </ol>

        <p>Notice that in the i-th iteration, our array has n / 2<sup>i</sup> elements. This is because in every iteration we're cutting our array into half, meaning we're dividing its number of elements by two. This translates to multiplying the denominator with a 2. If we do that i times, we get n / 2<sup>i</sup>. Now, this procedure continues and with every larger i we get a smaller number of elements until we reach the last iteration in which we have only 1 element left. If we wish to find i to see in what iteration this will take place, we have to solve the following equation:</p>

        <p>1 = n / 2<sup>i</sup></p>

        <p>This will only be true when we have reached the final call to the binarySearch() function, not in the general case. So solving for i here will help us find in which iteration the recursion will finish. Multiplying both sides by 2<sup>i</sup> we get:</p>

        <p>2<sup>i</sup> = n</p>

        <p>Now, this equation should look familiar if you read the logarithms section above. Solving for i we have:</p>

        <p>i = log( n )</p>

        <p>This tells us that the number of iterations required to perform a binary search is log( n ) where n is the number of elements in the original array.</p>

        <p>If you think about it, this makes some sense. For example, take n = 32, an array of 32 elements. How many times do we have to cut this in half to get only 1 element? We get: 32 → 16 → 8 → 4 → 2 → 1. We did this 5 times, which is the logarithm of 32. Therefore, the complexity of binary search is Θ( log( n ) ).</p>

        <p>This last result allows us to compare binary search with linear search, our previous method. Clearly, as log( n ) is much smaller than n, it is reasonable to conclude that binary search is a much faster method to search within an array than linear search, so it may be advisable to keep our arrays sorted if we want to do many searches within them.</p>

        <div class='highlight'>
            <p class='thumb'><strong>Rule of thumb</strong>: Improving the asymptotic running time of a program often tremendously increases its performance, much more than any smaller "technical" optimizations such as using a faster programming language.</p>
        </div>

        <h2 id='sort'>Optimal sorting</h2>

        <p><strong>Congratulations.</strong> You now know about analyzing the complexity of algorithms, asymptotic behavior of functions and big-O notation. You also know how to intuitively figure out that the complexity of an algorithm is O( 1 ), O( log( n ) ), O( n ), O( n<sup>2</sup> ) and so forth. You know the symbols o, O, ω, Ω and Θ and what worst-case analysis means. If you've come this far, this tutorial has already served its purpose.</p>

        <p>This final section is optional. It is a little more involved, so feel free to skip it if you feel overwhelmed by it. It will require you to focus and spend some moments working through the exercises. However, it will provide you with a very useful method in algorithm complexity analysis which can be very powerful, so it's certainly worth understanding.</p>

        <p>We looked at a sorting implementation above called a selection sort. We mentioned that selection sort is not optimal. An <em>optimal algorithm</em> is an algorithm that solves a problem in the best possible way, meaning there are no better algorithms for this. This means that all other algorithms for solving the problem have a worse or equal complexity to that optimal algorithm. There may be many optimal algorithms for a problem that all share the same complexity. The sorting problem can be solved optimally in various ways. We can use the same idea as with binary search to sort quickly. This sorting method is called <em>mergesort</em>.</p>

        <p>To perform a mergesort, we will first need to build a helper function that we will then use to do the actual sorting. We will make a <code>merge</code> function which takes two arrays that are both already sorted and merges them together into a big sorted array. This is easily done:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
            def merge( A, B ):
                if empty( A ):
                    return B
                if empty( B ):
                    return A
                if A[ 0 ] &lt; B[ 0 ]:
                    return concat( A[ 0 ], merge( A[ 1...A_n ], B ) )
                else:
                    return concat( B[ 0 ], merge( A, B[ 1...B_n ] ) )
        </pre>

        <p>The concat function takes an item, the "head", and an array, the "tail", and builds up and returns a new array which contains the given "head" item as the first thing in the new array and the given "tail" item as the rest of the elements in the array. For example, concat( 3, [ 4, 5, 6 ] ) returns [ 3, 4, 5, 6 ]. We use A_n and B_n to denote the sizes of arrays A and B respectively.</p>

        <div class='exercise'>
            <h3>Exercise 8</h3>

            <p>Verify that the above function actually performs a merge. Rewrite it in your favourite programming language in an iterative way (using <code>for</code> loops) instead of using recursion.</p>
        </div>

        <p>Analyzing this algorithm reveals that it has a running time of Θ( n ), where n is the length of the resulting array (n = A_n + B_n).</p>

        <div class='exercise'>
            <h3>Exercise 9</h3>

            <p>Verify that the running time of <code>merge</code> is Θ( n ).</p>
        </div>

        <p>Utilizing this function we can build a better sorting algorithm. The idea is the following: We split the array into two parts. We sort each of the two parts recursively, then we merge the two sorted arrays into one big array. In pseudocode:</p>

        <pre class='brush: python; gutter: false; toolbar: false;'>
        def mergeSort( A, n ):
            if n = 1:
                return A # it is already sorted
            middle = floor( n / 2 )
            leftHalf = A[ 1...middle ]
            rightHalf = A[ ( middle + 1 )...n ]
            return merge( mergeSort( leftHalf, middle ), mergeSort( rightHalf, n - middle ) )
        </pre>

        <p>This function is harder to understand than what we've gone through previously, so the following exercise may take you a few minutes.</p>

        <div class='exercise'>
            <h3>Exercise 10</h3>

            <p>Verify the correctness of <code>mergeSort</code>. That is, check to see if <code>mergeSort</code> as defined above actually correctly sorts the array it is given. If you're having trouble understanding why it works, try it with a small example array and run it "by hand". When running this function by hand, make sure leftHalf and rightHalf are what you get if you cut the array approximately in the middle; it doesn't have to be exactly in the middle if the array has an odd number of elements (that's what <code>floor</code> above is used for).</p>
        </div>

        <p>As a final example, let us analyze the complexity of <code>mergeSort</code>. In every step of <code>mergeSort</code>, we're splitting the array into two halves of equal size, similarly to <code>binarySearch</code>. However, in this case, we maintain both halves throughout execution. We then apply the algorithm recursively in each half. After the recursion returns, we apply the <code>merge</code> operation on the result which takes Θ( n ) time.</p>

        <p>So, we split the original array into two arrays of size n / 2 each. Then we merge those arrays, an operation that merges <var>n</var> elements and thus takes Θ( n ) time.</p>

        <p>Take a look at <strong>Figure 7</strong> to understand this recursion.</p>

        <div class='sidefigure'>
            <img src='images/mergesort-recursion.png' alt='N splits into N / 2 and N / 2. Each of those splits into N / 4 and N / 4, and the process continues until we have calls of size 1.' />
            <label><strong>Figure 7</strong>: The recursion tree of merge sort.</label>
        </div>

        <p>Let's see what's going on here. Each circle represents a call to the <code>mergeSort</code> function. The number written in the circle indicates the size of the array that is being sorted. The top blue circle is the original call to <code>mergeSort</code>, where we get to sort an array of size <var>n</var>. The arrows indicate recursive calls made between functions. The original call to <code>mergeSort</code> makes two calls to <code>mergeSort</code> on two arrays, each of size n / 2. This is indicated by the two arrows at the top. In turn, each of these calls makes two calls of its own to <code>mergeSort</code> two arrays of size n / 4 each, and so forth until we arrive at arrays of size 1. This diagram is called a <em>recursion tree</em>, because it illustrates how the recursion behaves and looks like a tree (the <em>root</em> is at the top and the <em>leaves</em> are at the bottom, so in reality it looks like an inversed tree).</p>

        <p>Notice that at each row in the above diagram, the total number of elements is n. To see this, take a look at each row individually. The first row contains only one call to <code>mergeSort</code> with an array of size <var>n</var>, so the total number of elements is <var>n</var>. The second row has two calls to <code>mergeSort</code> each of size n / 2. But n / 2 + n / 2 = n and so again in this row the total number of elements is <var>n</var>. In the third row, we have 4 calls each of which is applied on an n / 4-sized array, yielding a total number of elements equal to n / 4 + n / 4 + n / 4 + n / 4 = 4n / 4 = n. So again we get <var>n</var> elements. Now notice that at each row in this diagram the caller will have to perform a <code>merge</code> operation on the elements returned by the callees. For example, the circle indicated with red color has to sort n / 2 elements. To do this, it splits the n / 2-sized array into two n / 4-sized arrays, calls <code>mergeSort</code> recursively to sort those (these calls are the circles indicated with green color), then merges them together. This merge operation requires to merge n / 2 elements. At each row in our tree, the total number of elements merged is n. In the row that we just explored, our function merges n / 2 elements and the function on its right (which is in blue color) also has to merge n / 2 elements of its own. That yields n elements in total that need to be merged for the row we're looking at.</p>

        <p>By this argument, the complexity for each row is Θ( n ). We know that the number of rows in this diagram, also called the <em>depth</em> of the recursion tree, will be log( n ). The reasoning for this is exactly the same as the one we used when analyzing the complexity of binary search. We have log( n ) rows and each of them is Θ( n ), therefore the complexity of <code>mergeSort</code> is Θ( n * log( n ) ). This is much better than Θ( n<sup>2</sup> ) which is what selection sort gave us (remember that log( n ) is much smaller than n, and so n * log( n ) is much smaller than n * n = n<sup>2</sup>). If this sounds complicated to you, don't worry: It's not easy the first time you see it. Revisit this section and reread about the arguments here after you implement mergesort in your favourite programming language and validate that it works.</p>

        <p>As you saw in this last example, complexity analysis allows us to compare algorithms to see which one is better. Under these circumstances, we can now be pretty certain that merge sort will outperform selection sort for large arrays. This conclusion would be hard to draw if we didn't have the theoretical background of algorithm analysis that we developed. In practice, indeed sorting algorithms of running time Θ( n * log( n ) ) are used. For example, <a href='http://lxr.free-electrons.com/source/lib/sort.c'>the Linux kernel uses a sorting algorithm called heapsort</a>, which has the same running time as mergesort which we explored here, namely Θ( n log( n ) ) and so is optimal. Notice that we have not proven that these sorting algorithms are optimal. Doing this requires a slightly more involved mathematical argument, but rest assured that they can't get any better from a complexity point of view.</p>

        <p>Having finished reading this tutorial, the intuition you developed for algorithm complexity analysis should be able to help you design faster programs and focus your optimization efforts on the things that really matter instead of the minor things that don't matter, letting you work more productively. In addition, the mathematical language and notation developed in this article such as big-O notation is helpful in communicating with other software engineers when you want to argue about the running time of algorithms, so hopefully you will be able to do that with your newly acquired knowledge.</p>

        <h2 id='about'>About</h2>
        <p>This article is licensed under <a href='http://creativecommons.org/licenses/by/3.0/'>Creative Commons 3.0 Attribution</a>. This means you can copy/paste it, share it, post it on your own website, change it, and generally do whatever you want with it, providing you mention my name. Although you don't have to, if you base your work on mine, I encourage you to publish your own writings under Creative Commons so that it's easier for others to share and collaborate as well. In a similar fashion, I have to attribute the work I used here. The nifty icons that you see on this page are the <a href='http://p.yusukekamiyamane.com/'>fugue icons</a>. The beautiful striped pattern that you see in this design was created by <a href='http://leaverou.me/css3patterns/'>Lea Verou</a>. And, more importantly, the algorithms I know so that I was able to write this article were taught to me by my professors <a href='http://www.softlab.ntua.gr/~nickie/'>Nikos Papaspyrou</a> and <a href='http://www.softlab.ntua.gr/~fotakis/'>Dimitris Fotakis</a>.</p>

        <p>I'm currently a cryptography PhD candidate at <a href='http://di.uoa.gr'>the University of Athens</a>. When I wrote this article I was an undergraduate <a href='http://ece.ntua.gr/'>Electrical and Computer Engineering</a> undergraduate at the <a href='http://ntua.gr/'>National Technical University of Athens</a> mastering in <a href='http://www.cslab.ntua.gr'>software</a> and a coach at the <a href='http://pdp.gr/'>Greek Competition in Informatics</a>. Industry-wise I've worked as a member of the engineering team that built <a href='http://www.deviantart.com/'>deviantART</a>, a social network for artists, at the security teams of <a href='https://www.google.com'>Google</a> and <a href='https://twitter.com'>Twitter</a>, and two start-ups, Zino and Kamibu where we did social networking and video game development respectively. <a href='http://www.twitter.com/dionyziz'>Follow me on Twitter</a> or <a href='http://github.com/dionyziz'>on GitHub</a> if you enjoyed this, or <a href='mailto:dionyziz@gmail.com'>mail me</a> if you want to get in touch. Many young programmers don't have a good knowledge of the English language. E-mail me if you want to translate this article into your own native language so that more people can read it.</p>

        <p><strong>Thanks for reading.</strong> I didn't get paid to write this article, so if you liked it, <a href='mailto:dionyziz@gmail.com'>send me an e-mail</a> to say hello. I enjoy receiving pictures of places around the world, so feel free to attach a picture of yourself in your city!</p>

        <h2 id='references'>References</h2>
        <ol>
            <li>Cormen, Leiserson, Rivest, Stein. <a href='http://www.amazon.co.uk/Introduction-Algorithms-T-Cormen/dp/0262533057/ref=sr_1_1?ie=UTF8&amp;qid=1341414466&amp;sr=8-1'>Introduction to Algorithms</a>, MIT Press.</li>
            <li>Dasgupta, Papadimitriou, Vazirani. <a href='http://www.amazon.co.uk/Algorithms-Sanjoy-Dasgupta/dp/0073523402/ref=sr_1_1?s=books&amp;ie=UTF8&amp;qid=1341414505&amp;sr=1-1'>Algorithms</a>, McGraw-Hill Press.</li>
            <li>Fotakis. Course of <a href='http://discrete.gr/'>Discrete Mathematics</a> at the National Technical University of Athens.</li>
            <li>Fotakis. Course of <a href='http://www.corelab.ece.ntua.gr/courses/algorithms/'>Algorithms and Complexity</a> at the National Technical University of Athens.</li>
        </ol>

       <div id="disqus_thread"></div>
<?php
    return array(
        'title' => 'A Gentle Introduction to Algorithm Complexity Analysis',
        'content' => ob_get_clean()
    );
?>
